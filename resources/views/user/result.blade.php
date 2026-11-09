@extends('layouts.user')

@section('content')
<div class="space-y-6">

    @php
        $bestMenu = $bestMenu ?? ($rankingResults[0] ?? null);
    @endphp

    {{-- ═══════════════════════════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">
                Hasil Perangkingan Menu Gizi Seimbang
            </h2>
            <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">
                Urutan kelayakan dihitung menggunakan metode gabungan <span class="text-primary dark:text-blue-400">AHP – TOPSIS</span>.
                Dihitung pada: {{ now()->format('d M Y, H:i') }} WIB
            </p>
        </div>
        <a href="{{ route('admin.result') }}"
           class="bg-primary hover:bg-primary-hover text-white px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 shadow transition-all duration-200 hover:-translate-y-0.5">
            <span class="material-symbols-outlined !text-sm">refresh</span>
            Hitung Ulang
        </a>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         HERO: Rekomendasi Utama (Peringkat 1)
    ═══════════════════════════════════════════════════════════════ --}}
    @if($bestMenu)
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-900 via-primary to-blue-800 p-6 text-white shadow-sm border border-transparent dark:border-slate-800 transition-all duration-300 hover:shadow-md group">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(99,102,241,0.15)_0%,transparent_60%)]"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-amber-400/20 border border-amber-400/30 flex items-center justify-center text-amber-300 shrink-0 text-2xl shadow-inner">🏆</div>
                <div class="space-y-1">
                    <span class="inline-block px-2.5 py-0.5 bg-amber-400 text-slate-900 font-black text-[10px] uppercase tracking-wider rounded-full shadow-sm">
                        Rekomendasi Utama (Peringkat 1)
                    </span>
                    <h3 class="text-lg font-black tracking-tight text-white mt-1">
                        {{ $bestMenu['code'] }} — {{ $bestMenu['name'] }}
                    </h3>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10 shrink-0 text-center min-w-[120px]">
                <div class="text-[9px] font-bold text-blue-200 uppercase tracking-widest">Nilai Preferensi Vi</div>
                <div class="text-xl font-black text-amber-300 mt-0.5 tracking-tight">
                    {{ str_replace('.', ',', number_format($bestMenu['score'], 4)) }}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════
         TABEL HASIL AKHIR PERANGKINGAN
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/40 dark:bg-slate-800/50">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight">
                Tabel Hasil Akhir TOPSIS
            </h3>
            <p class="text-[11px] text-gray-400 dark:text-slate-400 mt-0.5 font-semibold">
                Diurutkan berdasarkan Nilai Preferensi (Vi) dari terbesar ke terkecil.
            </p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-4 py-3.5 text-center" style="width: 6%;">Rank</th>
                        <th class="px-4 py-3.5" style="width: 10%;">Nilai V</th>
                        <th class="px-4 py-3.5" style="width: 32%;">Alternatif</th>
                        <th class="px-4 py-3.5 text-end" style="width: 16%;">D⁺</th>
                        <th class="px-4 py-3.5 text-end" style="width: 16%;">D⁻</th>
                        <th class="px-4 py-3.5 text-end pr-6" style="width: 20%;">Nilai Preferensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @forelse($rankingResults as $res)
                    @php $label = 'V' . intval(substr($res['code'], 1)); @endphp
                    <tr class="transition-all duration-150 group/row
                        {{ $res['rank'] == 1 ? 'bg-emerald-500/5 dark:bg-emerald-500/5 font-medium' : 'hover:bg-slate-50/60 dark:hover:bg-slate-800/30' }}">
                        <td class="px-4 py-4 text-center">
                            @if($res['rank'] <= 3)
                                <span class="inline-flex w-7 h-7 items-center justify-center rounded-full text-xs font-black shadow-sm
                                    {{ $res['rank'] == 1 ? 'bg-amber-400 text-slate-950' : '' }}
                                    {{ $res['rank'] == 2 ? 'bg-slate-200 dark:bg-slate-600 text-slate-900 dark:text-white' : '' }}
                                    {{ $res['rank'] == 3 ? 'bg-amber-700 text-white' : '' }}">
                                    {{ $res['rank'] }}
                                </span>
                            @else
                                <span class="text-xs font-bold text-gray-400 dark:text-slate-500">{{ $res['rank'] }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 font-bold text-slate-800 dark:text-slate-200 tracking-tight">{{ $label }}</td>
                        <td class="px-4 py-4 text-xs font-medium text-gray-600 dark:text-slate-300 transition-colors leading-relaxed">
                            {{ $res['code'] }} — {{ $res['name'] }}
                        </td>
                        <td class="px-4 py-4 text-end font-mono text-xs font-semibold text-slate-600 dark:text-slate-400">
                            {{ str_replace('.', ',', number_format($res['d_pos'] ?? 0, 4)) }}
                        </td>
                        <td class="px-4 py-4 text-end font-mono text-xs font-semibold text-slate-600 dark:text-slate-400">
                            {{ str_replace('.', ',', number_format($res['d_neg'] ?? 0, 4)) }}
                        </td>
                        <td class="px-4 py-4 text-end pr-6 font-black text-slate-800 dark:text-slate-200 tracking-tight
                            {{ $res['rank'] == 1 ? 'text-emerald-600 dark:text-emerald-400' : '' }}">
                            {{ str_replace('.', ',', number_format($res['score'], 4)) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-xs font-semibold text-gray-400 dark:text-slate-500">
                            <span class="material-symbols-outlined !text-3xl block mb-2 text-gray-300 dark:text-slate-600">calculate</span>
                            Belum ada data untuk dihitung. Pastikan data kriteria dan alternatif sudah diisi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         TABEL DETAIL LANGKAH TOPSIS (Matriks Bobot Ternormalisasi Y)
    ═══════════════════════════════════════════════════════════════ --}}
    @if(!empty($steps) && !empty($rankingResults))
    <div x-data="{ open: false }" class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
        <button @click="open = !open"
                class="w-full p-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/40 dark:bg-slate-800/50 flex justify-between items-center hover:bg-gray-100/50 dark:hover:bg-slate-700/40 transition-colors">
            <div>
                <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight text-left">
                    Detail Matriks Perhitungan TOPSIS
                </h3>
                <p class="text-[11px] text-gray-400 dark:text-slate-400 mt-0.5 font-semibold text-left">
                    Klik untuk menampilkan / menyembunyikan tabel normalisasi dan pembobotan.
                </p>
            </div>
            <span class="material-symbols-outlined text-gray-400 dark:text-slate-500 transition-transform duration-200"
                  :class="open ? 'rotate-180' : ''">expand_more</span>
        </button>

        <div x-show="open" x-transition class="overflow-x-auto p-4 space-y-6">

            {{-- Bobot AHP yang digunakan --}}
            <div>
                <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-3">
                    Bobot Vektor Prioritas AHP (w<sub>j</sub>)
                </h4>
                <div class="flex flex-wrap gap-3">
                    @php
                        $matrixYItems = $steps['matrixY'] ?? [];
                    @endphp
                    @foreach($ahpWeights as $code => $info)
                    <div class="bg-primary/5 dark:bg-blue-500/10 border border-primary/10 dark:border-blue-500/20 rounded-xl px-4 py-2 text-center min-w-[100px]">
                        <div class="text-[10px] font-bold text-gray-400 dark:text-slate-400">{{ $code }} – {{ $info['label'] ?? $code }}</div>
                        <div class="text-sm font-black text-primary dark:text-blue-400">{{ number_format($info['weight'] ?? 0, 4) }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Matriks Ternormalisasi Berbobot (Y) --}}
            @if(isset($steps['matrixY']) && isset($criterias))
            <div>
                <h4 class="text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider mb-3">
                    Matriks Ternormalisasi Berbobot (y<sub>ij</sub> = w<sub>j</sub> × r<sub>ij</sub>)
                </h4>
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-wider">
                            <th class="px-3 py-2.5 text-left border border-gray-200/50 dark:border-slate-700/50">Alternatif</th>
                            @foreach($criterias as $crit)
                            <th class="px-3 py-2.5 text-center border border-gray-200/50 dark:border-slate-700/50">{{ $crit->code }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $orderedRankingResults = collect($rankingResults)->sortBy(fn($res) => intval(substr($res['code'], 1)))->values();
                        @endphp
                        @foreach($orderedRankingResults as $res)
                        @if(isset($steps['matrixY'][$res['id']]))
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/20 {{ $res['rank'] == 1 ? 'bg-emerald-50/40 dark:bg-emerald-950/10 font-semibold' : '' }}">
                            <td class="px-3 py-2 font-black text-primary dark:text-blue-400 border border-gray-200/40 dark:border-slate-700/40">
                                {{ $res['code'] }}
                            </td>
                            @foreach($criterias as $crit)
                            <td class="px-3 py-2 text-center font-mono text-slate-700 dark:text-slate-300 border border-gray-200/40 dark:border-slate-700/40">
                                {{ number_format($steps['matrixY'][$res['id']][$crit->code] ?? 0, 4) }}
                            </td>
                            @endforeach
                        </tr>
                        @endif
                        @endforeach
                        {{-- Baris Ideal Positif --}}
                        <tr class="bg-emerald-50 dark:bg-emerald-950/20 font-bold">
                            <td class="px-3 py-2 font-extrabold text-emerald-700 dark:text-emerald-400 border border-gray-200/40 dark:border-slate-700/40">A⁺ (Ideal+)</td>
                            @foreach($criterias as $crit)
                            <td class="px-3 py-2 text-center font-mono text-emerald-700 dark:text-emerald-400 border border-gray-200/40 dark:border-slate-700/40">
                                {{ number_format($steps['idealPos'][$crit->code] ?? 0, 4) }}
                            </td>
                            @endforeach
                        </tr>
                        {{-- Baris Ideal Negatif --}}
                        <tr class="bg-red-50/60 dark:bg-red-950/20 font-bold">
                            <td class="px-3 py-2 font-extrabold text-red-600 dark:text-red-400 border border-gray-200/40 dark:border-slate-700/40">A⁻ (Ideal−)</td>
                            @foreach($criterias as $crit)
                            <td class="px-3 py-2 text-center font-mono text-red-600 dark:text-red-400 border border-gray-200/40 dark:border-slate-700/40">
                                {{ number_format($steps['idealNeg'][$crit->code] ?? 0, 4) }}
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>
    @endif

</div>

{{-- Alpine.js CDN (untuk toggle accordion detail) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection
