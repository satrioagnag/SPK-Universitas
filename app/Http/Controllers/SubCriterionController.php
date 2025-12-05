<?php

namespace App\Http\Controllers;

use app\models\criteria;
use app\Models\Sub_Criterion;
use Illuminate\Http\Request;

class SubCriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCriteria = $criterion->subCriteria()->orderBy('score', 'desc')->get();
        return view('sub_criteria.index', compact('criterion', 'subCriteria'));
    }    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sub_criteria.create', compact('criterion'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|max:255',
            'score' => 'required|numeric',
        ]);

        $data['criteria_id'] = $criterion->id;

        Sub_Criterion::create($data);

        return redirect()
            ->route('criteria.sub_criteria.index', $criterion->id)
            ->with('success', 'Sub-criterion created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('sub_criteria.edit', compact('criterion', 'subCriterion'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'label' => 'required|max:255',
            'score' => 'required|numeric',
        ]);

        $subCriterion->update($data);

        return redirect()
            ->route('criteria.sub_criteria.index', $criterion->id)
            ->with('success', 'Sub-criterion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subCriterion->delete();

        return redirect()
            ->route('criteria.sub_criteria.index', $criterion->id)
            ->with('success', 'Sub-criterion deleted successfully.');
    }
}
