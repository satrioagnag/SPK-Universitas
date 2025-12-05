<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Sub_Criterion;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteria = Criteria::orderBy('code')->get();
        return view('criteria.index', compact('criteria'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('criterion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:criteria,code|max:10',
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric',
        ]);

        Criteria::create($data);

        return redirect()
            ->route('criteria.index')
            ->with('success', 'Criterion created successfully.');
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
    public function edit(Criteria $criteria)
    {
        return view('criteria.edit', compact('criterion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria)
    {
        $data = $request->validate([
            'code' => 'required|max:10|unique:criteria,code,' . $criteria->id,
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'required|numeric',
        ]);

        $criteria->update($data);

        return redirect()
            ->route('criteria.index')
            ->with('success', 'Criterion updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        return redirect()
            ->route('criteria.index', $criteria->id)
            ->with('success', 'Criterion deleted successfully.');
    }
}
