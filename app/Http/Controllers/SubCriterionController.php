<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\sub_criterion;
use Illuminate\Http\Request;

class SubCriterionController extends Controller
{
    public function index(Criteria $criteria)
    {
        $criterion = $criteria; // Alias for view consistency
        $subCriteria = $criteria->subCriteria()->orderBy('Score', 'desc')->get();
        return view('sub_criteria.index', compact('criterion', 'subCriteria'));
    }

    public function create(Criteria $criteria)
    {
        $criterion = $criteria; // Alias for view consistency
        return view('sub_criteria.create', compact('criterion'));
    }

    public function store(Request $request, Criteria $criteria)
    {
        $data = $request->validate([
            'label' => 'required|max:255',
            'score' => 'required|numeric',
        ]);

        sub_criterion::create([
            'criteria_id' => $criteria->id,
            'label' => $data['label'],
            'Score' => $data['score'],
        ]);

        return redirect()
            ->route('criteria.sub_criteria.index', $criteria->id)
            ->with('success', 'Sub-criterion created successfully.');
    }

    public function edit(sub_criterion $sub_criterion)
    {
        $subCriterion = $sub_criterion; // Alias for view consistency
        $criterion = $sub_criterion->criterion;
        return view('sub_criteria.edit', compact('criterion', 'subCriterion'));
    }

    public function update(Request $request, sub_criterion $sub_criterion)
    {
        $data = $request->validate([
            'label' => 'required|max:255',
            'score' => 'required|numeric',
        ]);

        $sub_criterion->update([
            'label' => $data['label'],
            'Score' => $data['score'],
        ]);

        return redirect()
            ->route('criteria.sub_criteria.index', $sub_criterion->criteria_id)
            ->with('success', 'Sub-criterion updated successfully.');
    }

    public function destroy(sub_criterion $sub_criterion)
    {
        $criteriaId = $sub_criterion->criteria_id;
        $sub_criterion->delete();

        return redirect()
            ->route('criteria.sub_criteria.index', $criteriaId)
            ->with('success', 'Sub-criterion deleted successfully.');
    }
}