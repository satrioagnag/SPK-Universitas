<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternatif;
use App\Models\alternatives_score;
use Illuminate\Support\Collection;

class TOPSISService
{
    /**
     * Hitung TOPSIS untuk kumpulan alternatif & kriteria aktif.
     *
     * @param \Illuminate\Support\Collection<Alternatif> $alternatives
     * @param \Illuminate\Support\Collection<Criteria>  $criteria
     * @return array [alternative_id => ['score' => float, 'rank' => int, 'd_plus' => float, 'd_minus' => float], ...]
     */
    public function calculate(Collection $alternatives, Collection $criteria): array
    {
        $m = $alternatives->count();  // alternatif
        $n = $criteria->count();      // kriteria

        if ($m === 0 || $n === 0) {
            return [];
        }

        // indexing
        $altIndexById = [];
        $critIndexById = [];
        $i = 0;
        foreach ($alternatives as $alt) {
            $altIndexById[$alt->id] = $i++;
        }
        $j = 0;
        foreach ($criteria as $crit) {
            $critIndexById[$crit->id] = $j++;
        }

        // build matrix X[i][j]
        $matrix = array_fill(0, $m, array_fill(0, $n, 0.0));

        $scores = alternatives_score::whereIn('alternative_id', $alternatives->pluck('id'))
            ->whereIn('criterion_id', $criteria->pluck('id'))
            ->get();

        foreach ($scores as $score) {
            $ai = $altIndexById[$score->alternative_id];
            $cj = $critIndexById[$score->criterion_id];
            $matrix[$ai][$cj] = (float) $score->Score;
        }

        // weights and types
        $weights = [];
        $types   = [];
        foreach ($criteria as $c) {
            $weights[] = (float) ($c->Weight ?? 0);
            $types[]   = $c->Type; // 'benefit' / 'cost'
        }

        // 1) normalisasi
        $norm = array_fill(0, $m, array_fill(0, $n, 0.0));
        for ($j = 0; $j < $n; $j++) {
            $den = 0.0;
            for ($i = 0; $i < $m; $i++) {
                $den += pow($matrix[$i][$j], 2);
            }
            $den = sqrt($den) ?: 1;

            for ($i = 0; $i < $m; $i++) {
                $norm[$i][$j] = $matrix[$i][$j] / $den;
            }
        }

        // 2) normalisasi terbobot
        $weighted = array_fill(0, $m, array_fill(0, $n, 0.0));
        for ($i = 0; $i < $m; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $weighted[$i][$j] = $norm[$i][$j] * $weights[$j];
            }
        }

        // 3) solusi ideal
        $idealPlus  = array_fill(0, $n, 0.0);
        $idealMinus = array_fill(0, $n, 0.0);

        for ($j = 0; $j < $n; $j++) {
            $col = array_column($weighted, $j);
            if ($types[$j] === 'benefit') {
                $idealPlus[$j]  = max($col);
                $idealMinus[$j] = min($col);
            } else { // cost
                $idealPlus[$j]  = min($col);
                $idealMinus[$j] = max($col);
            }
        }

        // 4) D+ dan D-
        $dPlus  = array_fill(0, $m, 0.0);
        $dMinus = array_fill(0, $m, 0.0);

        for ($i = 0; $i < $m; $i++) {
            $sumPlus = 0.0;
            $sumMinus = 0.0;
            for ($j = 0; $j < $n; $j++) {
                $sumPlus  += pow($weighted[$i][$j] - $idealPlus[$j], 2);
                $sumMinus += pow($weighted[$i][$j] - $idealMinus[$j], 2);
            }
            $dPlus[$i]  = sqrt($sumPlus);
            $dMinus[$i] = sqrt($sumMinus);
        }

        // 5) skor & ranking
        $results = [];
        $i = 0;
        foreach ($alternatives as $alt) {
            $v = ($dPlus[$i] + $dMinus[$i]) == 0
                ? 0
                : $dMinus[$i] / ($dPlus[$i] + $dMinus[$i]);

            $results[$alt->id] = [
                'score'   => $v,
                'd_plus'  => $dPlus[$i],
                'd_minus' => $dMinus[$i],
                // rank diisi setelah sort
            ];
            $i++;
        }

        // sort by score desc dan assign rank
        uasort($results, fn($a, $b) => $b['score'] <=> $a['score']);

        $rank = 1;
        foreach ($results as $altId => &$row) {
            $row['rank'] = $rank++;
        }

        return $results;
    }
}