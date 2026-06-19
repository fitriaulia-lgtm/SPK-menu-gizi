@extends('layouts.user')

@section('content')
<div class="space-y-6">

    {{-- ═══════════════════════════════════════════════════════════════
         SECTION 1: Hero Banner + Ringkasan Bobot AHP
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="grid grid-cols-12 gap-6">

        {{-- Hero Card: Rekomendasi Menu Teratas (Dinamis dari TOPSIS) --}}
        <div class="col-span-12 lg:col-span-8 relative overflow-hidden rounded-2xl min-h-[360px] flex items-end border border-transparent dark:border-slate-800/60 shadow-sm group transition-all duration-500 hover:shadow-xl">
            <img alt="Today's Featured Menu"
                 class="absolute inset-0 w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-700 ease-out"
                 src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=1200"/>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-900/40 to-transparent"></div>

            <div class="relative z-10 p-8 w-full flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="text-white max-w-lg space-y-2">
                    <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-400 dark:text-emerald-300 font-bold text-[11px] uppercase tracking-widest rounded-full border border-emerald-500/30">
                        Recommended Menu
                    </span>
                    @if($bestMenu)
                    <h2 class="text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">
                        Menu Teratas:
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">
                            {{ $bestMenu['code'] }} — {{ Str::limit($bestMenu['name'], 40) }}
                        </span>
                    </h2>
                    <p class="text-slate-300 text-xs font-medium leading-relaxed opacity-95">
                        Nilai preferensi tertinggi: <span class="text-emerald-300 font-black">{{ number_format($bestMenu['score'], 4) }}</span>.
                        Kombinasi menu ini memiliki kandungan gizi terbaik berdasarkan perhitungan AHP-TOPSIS.
                    </p>
                    @else
                    <h2 class="text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">
                        Belum Ada Data Menu
                    </h2>
                    <p class="text-slate-300 text-xs font-medium leading-relaxed opacity-95">
                        Tambahkan data alternatif menu terlebih dahulu, lalu jalankan perhitungan TOPSIS untuk mendapatkan rekomendasi.
                    </p>
                    @endif
                </div>
                <a href="{{ route('admin.result') }}"
                   class="bg-gradient-to-r from-emerald-400 to-teal-500 hover:from-emerald-500 hover:to-teal-600 text-white px-6 py-3 rounded-xl font-extrabold text-xs flex items-center gap-2 shadow-lg transition-all duration-300 hover:-translate-y-0.5 shrink-0 group/btn">
                    <span class="material-symbols-outlined">calculate</span>
                    Hitung &amp; Analisis Menu (TOPSIS)
                    <span class="material-symbols-outlined !text-sm transform group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        {{-- Kartu Bobot AHP (Dinamis dari controller) --}}
        <div class="col-span-12 lg:col-span-4 bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl p-6 flex flex-col shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-5">
                <div class="space-y-0.5">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base tracking-tight">Kriteria Parameter Gizi</h3>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-slate-400">Prioritas Vektor Bobot (AHP)</p>
                </div>
                <span class="material-symbols-outlined text-primary dark:text-blue-400 transform group-hover:rotate-12 transition-transform duration-300">leaderboard</span>
            </div>

            {{-- Warna per kriteria --}}
            @php
            $colorMap = [
                'C1' => ['stroke' => 'stroke-blue-500 dark:stroke-blue-400',   'text' => 'text-blue-600 dark:text-blue-400'],
                'C2' => ['stroke' => 'stroke-emerald-600 dark:stroke-emerald-400', 'text' => 'text-emerald-600 dark:text-emerald-400'],
                'C3' => ['stroke' => 'stroke-orange-500 dark:stroke-orange-400', 'text' => 'text-orange-600 dark:text-orange-400'],
                'C4' => ['stroke' => 'stroke-cyan-600 dark:stroke-cyan-500',    'text' => 'text-cyan-600 dark:text-cyan-400'],
                'C5' => ['stroke' => 'stroke-teal-600 dark:stroke-teal-500',    'text' => 'text-teal-600 dark:text-teal-400'],
            ];
            $circumference = 251.2; 
            @endphp

            <div class="space-y-3.5 flex-grow flex flex-col justify-center">
                @foreach($ahpWeights as $code => $info)
                @php
                    $offset = $circumference - ($info['pct'] / 100) * $circumference;
                    $colors = $colorMap[$code] ?? ['stroke' => 'stroke-gray-400', 'text' => 'text-gray-500'];
                @endphp
                <div class="flex items-center gap-4 p-1.5 rounded-xl">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none"
                                    class="stroke-gray-100 dark:stroke-slate-700/40" stroke-width="12"></circle>
                            <circle cx="50" cy="50" r="40" fill="none"
                                    class="{{ $colors['stroke'] }}" stroke-width="12"
                                    stroke-dasharray="{{ $circumference }}"
                                    stroke-dashoffset="{{ $offset }}"
                                    stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute text-[10px] font-extrabold {{ $colors['text'] }}">{{ $info['pct'] }}%</div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-black text-slate-800 dark:text-slate-200 tracking-tight">
                                {{ $info['label'] }} ({{ $code }})
                            </span>
                            <span class="text-xs font-bold {{ $colors['text'] }}">{{ $info['weight'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════════════════════
         SECTION 2: Statistik Ringkas
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $stats = [
                ['icon' => 'restaurant_menu', 'value' => $alternatives->count(), 'label' => 'Total Alternatif Menu', 'color' => 'text-primary dark:text-blue-400'],
                ['icon' => 'analytics',       'value' => 5,                       'label' => 'Kriteria Gizi Aktif',   'color' => 'text-emerald-600 dark:text-emerald-400'],
                ['icon' => 'military_tech',   'value' => $bestMenu ? $bestMenu['code'] : '-', 'label' => 'Peringkat 1 TOPSIS', 'color' => 'text-amber-500 dark:text-amber-400'],
                ['icon' => 'verified',        'value' => 'CR=2.47%', 'label' => 'Konsistensi AHP', 'color' => 'text-teal-600 dark:text-teal-400'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
            <div class="flex items-center gap-3 mb-2">
                <span class="material-symbols-outlined {{ $stat['color'] }} !text-xl">{{ $stat['icon'] }}</span>
            </div>
            <div class="text-2xl font-black {{ $stat['color'] }} tracking-tight">{{ $stat['value'] }}</div>
            <div class="text-[11px] font-semibold text-gray-400 dark:text-slate-400 mt-0.5">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </section>

    {{-- ═══════════════════════════════════════════════════════════════
         SECTION 3: Tabel Daftar Alternatif Menu (dari database)
    ═══════════════════════════════════════════════════════════════ --}}
    <section class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/40 dark:bg-slate-800/50">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight">
                Daftar Alternatif Menu Makanan Berpotensi (MBG)
            </h3>
            <div class="flex items-center gap-3">
                <span class="px-2.5 py-0.5 bg-primary/10 dark:bg-blue-500/10 text-primary dark:text-blue-400 rounded-full text-[11px] font-bold">
                    Total: {{ $alternatives->count() }} Alternatif Menu
                </span>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('alternatives.create') }}"
                   class="bg-primary hover:bg-primary-hover text-white px-3 py-1.5 rounded-lg font-bold text-[11px] flex items-center gap-1 shadow transition-all duration-200 hover:-translate-y-0.5">
                    <span class="material-symbols-outlined !text-sm">add</span>
                    Tambah Menu
                </a>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-6 py-3.5" style="width: 12%;">Kode Menu</th>
                        <th class="px-6 py-3.5" style="width: 63%;">Komposisi Hidangan Sajian</th>
                        <th class="px-6 py-3.5 text-center" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @forelse($alternatives as $alt)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-all duration-150">
                        <td class="px-6 py-4 font-black text-primary dark:text-blue-400 tracking-tight">{{ $alt->code }}</td>
                        <td class="px-6 py-4 font-medium text-gray-600 dark:text-slate-300 text-xs leading-relaxed">{{ $alt->name }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.result') }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/30 dark:hover:bg-emerald-900/40 text-emerald-700 dark:text-emerald-400 font-bold text-[11px] rounded-lg transition-colors">
                                    <span class="material-symbols-outlined !text-sm">leaderboard</span>
                                    Lihat Ranking
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('alternatives.edit', $alt->id) }}"
                                   class="p-1.5 bg-slate-100 hover:bg-primary/10 text-slate-600 hover:text-primary dark:bg-slate-700/50 dark:hover:bg-blue-500/20 dark:text-slate-300 dark:hover:text-blue-400 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined !text-base">edit</span>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-xs font-semibold text-gray-400 dark:text-slate-500">
                            <span class="material-symbols-outlined !text-3xl block mb-2 text-gray-300 dark:text-slate-600">restaurant_menu</span>
                            Belum ada data alternatif menu. 
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('alternatives.create') }}" class="text-primary dark:text-blue-400 underline ml-1">Tambah sekarang</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection