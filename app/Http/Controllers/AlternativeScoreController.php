<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeScore;
use Illuminate\Http\Request;

class AlternativeScoreController extends Controller
{
    public function editbyAlternative(Alternative $Alternative){
        $criteria = Criterion::where('is_active', true)->orderBy('code')->get();

        // Ambil nilai yang sudah ada
        $scores = AlternativeScore::where('alternative_id', $Alternative->id)->get()
            ->keyBy('criterion_id');

        return view('scores.edit_by_alternative', compact('alternative', 'criteria', 'scores'));
    }
    public function updateByAlternative(Request $request, Alternative $Alternative)
    {
        $criteria = Criterion::where('is_active', true)->get();

        foreach ($criteria as $criterion) {
            $value = $request->input("criteria.{$criterion->id}.value");
            $subId = $request->input("criteria.{$criterion->id}.sub_criterion_id");

            if ($value === null) {
                continue;
            }

            UniversityScore::updateOrCreate(
                [
                    'alternative_id' => $Alternative->id,
                    'criterion_id'  => $criterion->id,
                ],
                [
                    'sub_criterion_id' => $subId ?: null,
                    'value'            => $value,
                ]
            );
        }

        return redirect()
            ->route('alternative.index')
            ->with('success', 'Scores updated for ' . $Alternative->name);
    }

    //Catatan: form di view harus kirim data seperti:
//criteria[ID_KRITERIA][value] dan criteria[ID_KRITERIA][sub_criterion_id].
}
