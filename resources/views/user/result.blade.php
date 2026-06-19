@extends('layouts.user')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-secondary mb-1">Hasil Perangkingan Menu Gizi Seimbang</h4>
            <p class="text-muted mb-0">Rekomendasi diurutkan secara objektif berdasarkan nilai kedekatan relatif tertinggi terhadap solusi ideal positif.</p>
        </div>
        <button class="btn btn-outline-secondary btn-sm bg-white shadow-sm" onclick="window.print()"><i class="fa-solid fa-print me-1"></i> Cetak Laporan</button>
    </div>

    <!-- Menu Terbaik Card -->
    <div class="card border-0 border-start border-5 border-success shadow-sm p-4 mb-4 bg-white" style="border-radius: 10px;">
        <div class="d-flex align-items-start">
            <div class="p-3 bg-success text-white rounded-circle me-4 fs-3 shadow-sm"><i class="fa-solid fa-trophy"></i></div>
            <div>
                <span class="badge bg-success mb-2 text-uppercase px-3 py-1 rounded-pill">Rekomendasi Utama (Peringkat 1)</span>
                <h4 class="fw-bold text-dark mb-1">A10 - Nasi putih, fried chicken, tahu pong, mix vegetable, buah naga</h4>
                <p class="mb-0 text-muted">Nilai Preferensi Akhir ($V_i$): <strong class="text-success fs-5">0.7536</strong></p>
            </div>
        </div>
    </div>

    <!-- Tabel Peringkat Keseluruhan -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="fw-bold text-secondary mb-0"><i class="fa-solid fa-award me-2"></i>Urutan Kelayakan Seluruh Alternatif Menu</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary fw-semibold">
                        <tr>
                            <th class="text-center" style="width: 10%;">Peringkat</th>
                            <th style="width: 15%;">Kode Menu</th>
                            <th style="width: 55%;">Komposisi Sajian Makanan</th>
                            <th class="text-end pe-5" style="width: 20%;">Nilai Kedekatan ($V_i$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Baris Sesuai Hasil Perhitungan Pada Tabel 4.16 Lanjutan -->
                        <tr class="table-success table-opacity-10">
                            <td class="text-center fw-bold fs-5 text-success">1</td>
                            <td class="fw-bold text-primary">A10</td>
                            <td>Nasi putih, fried chicken, tahu pong, mix vegetable, buah naga</td>
                            <td class="text-end pe-5 fw-bold text-success">0.7536</td>
                        </tr>
                        <tr>
                            <td class="text-center fw-bold">2</td>
                            <td class="fw-bold text-primary">A12</td>
                            <td>Nasi kuning, telur dadar suwir, abon ayam, acar timun wortel, buah apel</td>
                            <td class="text-end pe-5 fw-bold text-dark">0.7270</td>
                        </tr>
                        <tr>
                            <td class="text-center fw-bold">3</td>
                            <td class="fw-bold text-primary">A1</td>
                            <td>Nasi kuning, abon ayam, tempe orek telur dadar suwir, anggur, timun tomat</td>
                            <td class="text-end pe-5 fw-bold text-dark">0.6450</td>
                        </tr>
                        <tr>
                            <td class="text-center fw-bold">4</td>
                            <td class="fw-bold text-primary">A8</td>
                            <td>Onigiri, chicken strip, salad sayur, bola-bola tahu, buah kelengkeng</td>
                            <td class="text-end pe-5 fw-bold text-dark">0.6311</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection