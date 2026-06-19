<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterias = Criteria::all();
        // Vektor bobot AHP tetap untuk ditampilkan di view kriteria
        $ahpWeights = [
            'C1' => 0.0953,
            'C2' => 0.3104,
            'C3' => 0.0592,
            'C4' => 0.2389,
            'C5' => 0.2961,
        ];
        return view('user.criterias.index', compact('criterias', 'ahpWeights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.criterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:5|unique:criterias,code',
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
        ]);

        Criteria::create($request->all());

        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        return view('user.criterias.edit', compact('criteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|string|max:5|unique:criterias,code,' . $criteria->id,
            'name' => 'required|string|max:255',
            'attribute' => 'required|in:benefit,cost',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
        ]);

        $criteria->update($request->all());

        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
