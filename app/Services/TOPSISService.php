<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\University;
use App\Models\UniversityScore;
use Illuminate\Support\Collection;

class TopsisService
{
    /**
     * Hitung TOPSIS untuk kumpulan universitas & kriteria aktif.
     *
     * @param \Illuminate\Support\Collection<University> $universities
     * @param \Illuminate\Support\Collection<Criterion>  $criteria
     * @return array [university_id => ['score' => float, 'rank' => int, 'd_plus' => float, 'd_minus' => float], ...]
     */
    public function calculate(Collection $universities, Collection $criteria): array
    {
        $m = $universities->count();  // alternatif
        $n = $criteria->count();      // kriteria

        if ($m === 0 || $n === 0) {
            return [];
        }

        // indexing
        $uIndexById = [];
        $cIndexById = [];
        $i = 0;
        foreach ($universities as $u) {
            $uIndexById[$u->id] = $i++;
        }
        $j = 0;
        foreach ($criteria as $c) {
            $cIndexById[$c->id] = $j++;
        }

        // build matrix X[i][j]
        $matrix = array_fill(0, $m, array_fill(0, $n, 0.0));

        $scores = UniversityScore::whereIn('university_id', $universities->pluck('id'))
            ->whereIn('criterion_id', $criteria->pluck('id'))
            ->get();

        foreach ($scores as $score) {
            $ui = $uIndexById[$score->university_id];
            $cj = $cIndexById[$score->criterion_id];
            $matrix[$ui][$cj] = (float) $score->value;
        }

        // weights and types
        $weights = [];
        $types   = [];
        foreach ($criteria as $c) {
            $weights[] = (float) ($c->weight ?? 0);
            $types[]   = $c->type; // 'benefit' / 'cost'
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
        foreach ($universities as $u) {
            $v = ($dPlus[$i] + $dMinus[$i]) == 0
                ? 0
                : $dMinus[$i] / ($dPlus[$i] + $dMinus[$i]);

            $results[$u->id] = [
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
        foreach ($results as $uid => &$row) {
            $row['rank'] = $rank++;
        }

        return $results;
    }
}
