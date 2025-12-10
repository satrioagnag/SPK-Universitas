<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        $criteria = Criteria::orderBy('Code')->get();
        return view('criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('criteria.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:criterias,Code|max:10',
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'nullable|numeric',
        ]);

        Criteria::create([
            'Code' => $data['code'],
            'Name' => $data['name'],
            'Type' => $data['type'],
            'Weight' => $data['weight'] ?? 0,
        ]);

        return redirect()
            ->route('criteria.index')
            ->with('success', 'Criterion created successfully.');
    }

    public function edit(Criteria $criteria)
    {
        return view('criteria.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $data = $request->validate([
            'code' => 'required|max:10|unique:criterias,Code,' . $criteria->id,
            'name' => 'required|max:255',
            'type' => 'required|in:benefit,cost',
            'weight' => 'nullable|numeric',
        ]);

        $criteria->update([
            'Code' => $data['code'],
            'Name' => $data['name'],
            'Type' => $data['type'],
            'Weight' => $data['weight'] ?? $criteria->Weight,
        ]);

        return redirect()
            ->route('criteria.index')
            ->with('success', 'Criterion updated successfully.');
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        return redirect()
            ->route('criteria.index')
            ->with('success', 'Criterion deleted successfully.');
    }
}