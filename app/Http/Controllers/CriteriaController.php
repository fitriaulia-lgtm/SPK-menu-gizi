<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriteriaController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    private function backupScores(): void
    {
        DB::table('alternatives')->whereNull('score_backup')->update([
            'score_backup' => DB::raw('score'),
        ]);
    }

    private function invalidateScores(): void
    {
        DB::table('alternatives')->update(['score' => null]);
        TopsisService::clearCache();
    }

    private function restoreBackup(): void
    {
        DB::table('alternatives')->whereNotNull('score_backup')->update([
            'score' => DB::raw('score_backup'),
            'score_backup' => null,
        ]);
        TopsisService::clearCache();
    }

    public function index()
    {
        $criterias = Criteria::all();
        $ahpWeights = $this->topsisService->getWeights();

        return view('user.criterias.index', compact('criterias', 'ahpWeights'));
    }

    public function create()
    {
        return view('user.criterias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:25|unique:criterias,code',
            'name' => 'required|string|max:25',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'nullable|numeric|min:0',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
        ]);

        $this->backupScores();

        Criteria::create($request->only(['code', 'name', 'attribute', 'weight']));

        $this->invalidateScores();

        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil ditambahkan. Nilai preferensi akan dihitung ulang otomatis.');
    }

    public function edit(Criteria $criteria)
    {
        return view('user.criterias.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $request->validate([
            'code' => 'required|string|max:25|unique:criterias,code,' . $criteria->id,
            'name' => 'required|string|max:25',
            'attribute' => 'required|in:benefit,cost',
            'weight' => 'nullable|numeric|min:0',
        ], [
            'code.required' => 'Kode kriteria wajib diisi.',
            'code.unique' => 'Kode kriteria sudah digunakan.',
            'name.required' => 'Nama kriteria wajib diisi.',
            'weight.required' => 'Bobot AHP wajib diisi.',
        ]);

        $this->backupScores();

        $criteria->update($request->only(['code', 'name', 'attribute', 'weight']));

        $this->invalidateScores();

        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil diperbarui. Nilai preferensi akan dihitung ulang otomatis.');
    }

    public function destroy(Criteria $criteria)
    {
        $this->backupScores();

        $criteria->delete();

        $this->restoreBackup();

        return redirect()->route('criterias.index')->with('success', 'Kriteria berhasil dihapus. Perhitungan sebelumnya dikembalikan.');
    }
}
