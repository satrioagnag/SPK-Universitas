<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alternatives = Alternatif::orderBy('code')->get();
        return view('alternatives.index', compact('alternatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('alternatives.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:alternatives,code|max:10',
            'name' => 'required|max:255',
        ]);

        Alternatif::create($data);

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternative created successfully.');
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
        return view('alternatives.edit', compact('alternative'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'code' => 'required|max:10|unique:alternatives,code,' . $id,
            'name' => 'required|max:255',
        ]);

        $alternative = Alternatif::findOrFail($id);
        $alternative->update($data);

        return redirect()->route('alternatives.index')
            ->with('success', 'Alternative updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $alternative)
    {
        // $alternative->delete();

        // return redirect()->route('alternatives.index')
        //     ->with('success', 'Alternative deleted successfully.');
    }
}
