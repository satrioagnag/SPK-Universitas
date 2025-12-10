<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternatif;
use App\Models\alternatives_score;
use Illuminate\Http\Request;

class AlternativeScoreController extends Controller
{
    public function editByAlternative(Alternatif $alternative)
    {
        $criteria = Criteria::orderBy('Code')->get();

        // Ambil nilai yang sudah ada
        $scores = alternatives_score::where('alternative_id', $alternative->id)->get()
            ->keyBy('criterion_id');

        return view('scores.edit_by_alternative', compact('alternative', 'criteria', 'scores'));
    }

    public function updateByAlternative(Request $request, Alternatif $alternative)
    {
        $criteria = Criteria::all();

        foreach ($criteria as $criterion) {
            $value = $request->input("criteria.{$criterion->id}.value");
            $subId = $request->input("criteria.{$criterion->id}.sub_criterion_id");

            if ($value === null || $value === '') {
                continue;
            }

            alternatives_score::updateOrCreate(
                [
                    'alternative_id' => $alternative->id,
                    'criterion_id'  => $criterion->id,
                ],
                [
                    'sub_criterion_id' => $subId ?: null,
                    'Score' => $value,
                ]
            );
        }

        return redirect()
            ->route('alternatives.index')
            ->with('success', 'Scores updated for ' . $alternative->Name);
    }
}