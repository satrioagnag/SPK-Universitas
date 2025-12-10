<?php
// File: app/Http/Controllers/AlternativeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;

class AlternativeController extends Controller
{
    public function index()
    {
        $alternatives = Alternatif::orderBy('Code')->get();
        return view('alternatives.index', compact('alternatives'));
    }

    public function create()
    {
        return view('alternatives.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:alternatifs,Code|max:10',
            'name' => 'required|max:255',
        ]);

        Alternatif::create([
            'Code' => $data['code'],
            'Name' => $data['name'],
        ]);

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternative created successfully.');
    }

    public function edit(Alternatif $alternative)
    {
        return view('alternatives.edit', compact('alternative'));
    }

    public function update(Request $request, Alternatif $alternative)
    {
        $data = $request->validate([
            'code' => 'required|max:10|unique:alternatifs,Code,' . $alternative->id,
            'name' => 'required|max:255',
        ]);

        $alternative->update([
            'Code' => $data['code'],
            'Name' => $data['name'],
        ]);

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternative updated successfully.');
    }

    public function destroy(Alternatif $alternative)
    {
        $alternative->delete();

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternative deleted successfully.');
    }
}
