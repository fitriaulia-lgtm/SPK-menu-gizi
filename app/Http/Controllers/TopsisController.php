<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Services\TopsisService;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    /**
     * Membuka dashboard yang berisi daftar alternatif menu dari database
     */
    public function index()
    {
        // Mengambil data alternatif riil dari database
        $alternatives = Alternative::all();

        return view('user.dashboard', compact('alternatives'));
    }

    /**
     * Memicu perhitungan matematika TOPSIS dan menampilkan hasil perangkingan
     */
    public function calculate()
    {
        // Menjalankan kalkulasi TOPSIS secara dinamis dari database
        $topsisData = $this->topsisService->calculate();

        $rankingResults = $topsisData['rankingResults'];
        $bestMenu = $topsisData['bestMenu'];
        $steps = $topsisData['steps']; // Bisa digunakan di view jika ingin menampilkan rincian tabel normalisasi

        return view('user.result', compact('rankingResults', 'bestMenu', 'steps'));
    }
}