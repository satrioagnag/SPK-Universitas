<?php

namespace App\Services;

use App\Models\criteria_pairwise;
use App\Models\Criteria;
use Illuminate\Support\Collection;

class AHPService
{
    /**
     * Hitung bobot AHP untuk kumpulan kriteria.
     *
     * @param \Illuminate\Support\Collection<Criteria> $criteria
     * @return array [
     *   'weights' => [criterion_id => weight, ...],
     *   'ci' => float,
     *   'cr' => float,
     * ]
     */
    public function calculateForCriteria(Collection $criteria): array
    {
        $n = $criteria->count();
        if ($n === 0) {
            return ['weights' => [], 'ci' => 0, 'cr' => 0];
        }

        // Map criterion_id -> index
        $indexById = [];
        $i = 0;
        foreach ($criteria as $criterion) {
            $indexById[$criterion->id] = $i++;
        }

        // Inisialisasi matriks NxN dengan 1 di diagonal
        $matrix = array_fill(0, $n, array_fill(0, $n, 1.0));

        // Ambil semua pairwise untuk kriteria ini
        $pairs = criteria_pairwise::whereIn('criterion_row_id', $criteria->pluck('id'))
            ->whereIn('criterion_col_id', $criteria->pluck('id'))
            ->get();

        foreach ($pairs as $pair) {
            $row = $indexById[$pair->criterion_row_id];
            $col = $indexById[$pair->criterion_col_id];

            if ($row === $col) {
                $matrix[$row][$col] = 1.0;
            } else {
                $matrix[$row][$col] = (float) $pair->value;
                $matrix[$col][$row] = 1.0 / (float) $pair->value;
            }
        }

        // 1) jumlah kolom
        $colSums = array_fill(0, $n, 0.0);
        for ($j = 0; $j < $n; $j++) {
            for ($r = 0; $r < $n; $r++) {
                $colSums[$j] += $matrix[$r][$j];
            }
            // avoid division by zero
            if ($colSums[$j] == 0) {
                $colSums[$j] = 1;
            }
        }

        // 2) normalisasi & rata-rata baris → bobot
        $weights = array_fill(0, $n, 0.0);
        for ($r = 0; $r < $n; $r++) {
            $rowSum = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $normalized = $matrix[$r][$j] / $colSums[$j];
                $rowSum += $normalized;
            }
            $weights[$r] = $rowSum / $n;
        }

        // 3) lambda_max
        $lambdaMax = 0.0;
        for ($r = 0; $r < $n; $r++) {
            $rowWeightedSum = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $rowWeightedSum += $matrix[$r][$j] * $weights[$j];
            }
            $lambdaMax += $rowWeightedSum / $weights[$r];
        }
        $lambdaMax /= $n;

        // 4) CI & CR
        $ci = ($lambdaMax - $n) / ($n - 1);

        $riTable = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];
        $ri = $riTable[$n] ?? 1.49;
        $cr = $ri == 0 ? 0 : $ci / $ri;

        // Map kembali ke criterion_id
        $resultWeights = [];
        $i = 0;
        foreach ($criteria as $criterion) {
            $resultWeights[$criterion->id] = $weights[$i++];
        }

        return [
            'weights' => $resultWeights,
            'ci'      => $ci,
            'cr'      => $cr,
        ];
    }
}
