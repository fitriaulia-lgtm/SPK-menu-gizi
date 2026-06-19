<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Memuat alternatif beserta nilai-nilai gizinya untuk ditabulasikan
        $alternatives = Alternative::with('alternativeValues.criteria')->get();
        $criterias = Criteria::all();
        return view('user.alternatives.index', compact('alternatives', 'criterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterias = Criteria::all();
        return view('user.alternatives.create', compact('criterias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:5|unique:alternatives,code',
            'name' => 'required|string',
            'values' => 'required|array',
            'values.*' => 'required|numeric|min:0',
        ], [
            'code.required' => 'Kode alternatif wajib diisi.',
            'code.unique' => 'Kode alternatif sudah digunakan.',
            'name.required' => 'Nama/Komposisi menu makanan wajib diisi.',
            'values.*.required' => 'Setiap nilai kriteria wajib diisi.',
            'values.*.numeric' => 'Nilai kriteria harus berupa angka desimal/bulat.',
        ]);

        DB::transaction(function () use ($request) {
            $alternative = Alternative::create([
                'code' => $request->code,
                'name' => $request->name,
            ]);

            foreach ($request->values as $criteriaId => $value) {
                AlternativeValue::create([
                    'alternative_id' => $alternative->id,
                    'criteria_id' => $criteriaId,
                    'value' => (double)$value,
                ]);
            }
        });

        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternative $alternative)
    {
        $criterias = Criteria::all();
        // Memuat nilai yang ada dipetakan berdasarkan criteria_id
        $values = AlternativeValue::where('alternative_id', $alternative->id)
            ->pluck('value', 'criteria_id')
            ->toArray();

        return view('user.alternatives.edit', compact('alternative', 'criterias', 'values'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternative $alternative)
    {
        $request->validate([
            'code' => 'required|string|max:5|unique:alternatives,code,' . $alternative->id,
            'name' => 'required|string',
            'values' => 'required|array',
            'values.*' => 'required|numeric|min:0',
        ], [
            'code.required' => 'Kode alternatif wajib diisi.',
            'code.unique' => 'Kode alternatif sudah digunakan.',
            'name.required' => 'Nama/Komposisi menu makanan wajib diisi.',
            'values.*.required' => 'Setiap nilai kriteria wajib diisi.',
            'values.*.numeric' => 'Nilai kriteria harus berupa angka.',
        ]);

        DB::transaction(function () use ($request, $alternative) {
            $alternative->update([
                'code' => $request->code,
                'name' => $request->name,
            ]);

            foreach ($request->values as $criteriaId => $value) {
                AlternativeValue::updateOrCreate(
                    [
                        'alternative_id' => $alternative->id,
                        'criteria_id' => $criteriaId
                    ],
                    [
                        'value' => (double)$value
                    ]
                );
            }
        });

        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alternative $alternative)
    {
        $alternative->delete();
        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil dihapus.');
    }
}
