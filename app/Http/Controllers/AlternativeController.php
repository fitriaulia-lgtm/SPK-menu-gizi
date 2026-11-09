<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeValue;
use App\Services\TopsisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlternativeController extends Controller
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
        $alternatives = Alternative::with('alternativeValues')->get();
        $criterias = Criteria::orderBy('id')->get();

        $criteriasById = [];
        foreach ($criterias as $crit) {
            $criteriasById[$crit->id] = $crit;
        }

        $altValues = [];
        foreach ($alternatives as $alt) {
            $altValues[$alt->id] = [];
            foreach ($alt->alternativeValues as $av) {
                $crit = $criteriasById[$av->criteria_id] ?? null;
                if ($crit) {
                    $altValues[$alt->id][$crit->code] = $av->value;
                }
            }
        }

        return view('user.alternatives.index', compact('alternatives', 'criterias', 'altValues'));
    }

    public function create()
    {
        $criterias = Criteria::orderBy('id')->get();
        return view('user.alternatives.create', compact('criterias'));
    }

    public function store(Request $request)
    {
        $criterias = Criteria::orderBy('id')->get()->keyBy('code');

        $rules = [
            'code' => 'required|string|max:25|unique:alternatives,code',
            'name' => 'required|string',
        ];
        $messages = [
            'code.required' => 'Kode alternatif wajib diisi.',
            'code.unique' => 'Kode alternatif sudah digunakan.',
            'name.required' => 'Komposisi menu makanan wajib diisi.',
        ];
        $attributes = [];
        foreach ($criterias as $code => $crit) {
            $rules[$code] = 'required|numeric|min:0';
            $attributes[$code] = $crit->name;
            $messages[$code . '.required'] = 'Nilai ' . $crit->name . ' wajib diisi.';
            $messages[$code . '.numeric'] = 'Nilai ' . $crit->name . ' harus berupa angka.';
            $messages[$code . '.min.0'] = 'Nilai ' . $crit->name . ' tidak boleh negatif.';
        }

        $request->validate($rules, $messages, $attributes);

        $this->backupScores();

        $alternative = Alternative::create([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        foreach ($criterias as $code => $crit) {
            if ($request->has($code)) {
                AlternativeValue::create([
                    'alternative_id' => $alternative->id,
                    'criteria_id' => $crit->id,
                    'value' => (float) $request->input($code),
                ]);
            }
        }

        $this->invalidateScores();

        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil ditambahkan. Nilai preferensi akan dihitung ulang otomatis.');
    }

    public function edit(Alternative $alternative)
    {
        $alternative->load('alternativeValues');
        $criterias = Criteria::orderBy('id')->get();
        return view('user.alternatives.edit', compact('alternative', 'criterias'));
    }

    public function update(Request $request, Alternative $alternative)
    {
        $criterias = Criteria::orderBy('id')->get()->keyBy('code');

        $rules = [
            'code' => 'required|string|max:25|unique:alternatives,code,' . $alternative->id,
            'name' => 'required|string',
        ];
        $messages = [
            'code.required' => 'Kode alternatif wajib diisi.',
            'code.unique' => 'Kode alternatif sudah digunakan.',
            'name.required' => 'Komposisi menu makanan wajib diisi.',
        ];
        $attributes = [];
        foreach ($criterias as $code => $crit) {
            $rules[$code] = 'required|numeric|min:0';
            $attributes[$code] = $crit->name;
            $messages[$code . '.required'] = 'Nilai ' . $crit->name . ' wajib diisi.';
            $messages[$code . '.numeric'] = 'Nilai ' . $crit->name . ' harus berupa angka.';
            $messages[$code . '.min.0'] = 'Nilai ' . $crit->name . ' tidak boleh negatif.';
        }

        $request->validate($rules, $messages, $attributes);

        $this->backupScores();

        $alternative->update([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        foreach ($criterias as $code => $crit) {
            AlternativeValue::updateOrCreate(
                ['alternative_id' => $alternative->id, 'criteria_id' => $crit->id],
                ['value' => (float) $request->input($code, 0)]
            );
        }

        $this->invalidateScores();

        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil diperbarui.');
    }

    public function destroy(Alternative $alternative)
    {
        $this->backupScores();

        $alternative->delete();

        $this->restoreBackup();

        return redirect()->route('alternatives.index')->with('success', 'Alternatif menu berhasil dihapus. Perhitungan sebelumnya dikembalikan.');
    }
}
