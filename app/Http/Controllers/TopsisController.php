<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Services\TopsisService;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Membuka dashboard yang berisi ringkasan data SPK dari database.
     */
    public function index()
    {
        // Ambil alternatif dari database dengan eager loading nilai gizi
        $alternatives = Alternative::with('alternativeValues.criteria')->get();

        // Bobot AHP untuk ditampilkan di kartu dashboard
        $ahpWeights = [
            'C1' => ['label' => 'Energi',      'weight' => 0.0953, 'pct' => 10],
            'C2' => ['label' => 'Protein',     'weight' => 0.3104, 'pct' => 31],
            'C3' => ['label' => 'Lemak',       'weight' => 0.0592, 'pct' =>  6],
            'C4' => ['label' => 'Karbohidrat', 'weight' => 0.2389, 'pct' => 24],
            'C5' => ['label' => 'Serat',       'weight' => 0.2961, 'pct' => 30],
        ];

        // Hitung TOPSIS untuk menampilkan rekomendasi teratas di hero card
        $topsisData = $this->topsisService->calculate();
        $bestMenu   = $topsisData['bestMenu'];

        return view('user.dashboard', compact('alternatives', 'ahpWeights', 'bestMenu'));
    }

    /**
     * Memicu perhitungan matematika TOPSIS dan menampilkan hasil perangkingan.
     */
    public function calculate()
    {
        $topsisData = $this->topsisService->calculate();

        $rankingResults = $topsisData['rankingResults'];
        $bestMenu       = $topsisData['bestMenu'];
        $steps          = $topsisData['steps'];
        $criterias      = Criteria::all();

        return view('user.result', compact('rankingResults', 'bestMenu', 'steps', 'criterias'));
    }
}
