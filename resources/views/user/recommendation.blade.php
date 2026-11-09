@extends('layouts.user')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">Rekomendasi Menu Gizi Seimbang</h2>
            <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">Atur kebutuhan kandungan gizi menggunakan slider di bawah, lalu klik Cari Rekomendasi. Sistem akan menampilkan menu yang paling sesuai menggunakan metode AHP-TOPSIS.</p>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/40 dark:bg-slate-800/50">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight">Bentuk Kebutuhan Gizi</h3>
            <p class="text-[11px] text-gray-400 dark:text-slate-400 mt-0.5 font-semibold">Sesuaikan slider sesuai kebutuhan harian. Semua kriteria bersifat opsional.</p>
        </div>
        <div class="p-5">
            <form method="GET" action="{{ route('admin.recommendation') }}" class="space-y-5">
                @foreach($criterias as $code => $crit)
                    @php
                        $range = $ranges[$code] ?? ['min' => 0, 'max' => 100];
                        $min = (float) $range['min'];
                        $max = (float) $range['max'];
                        $defaultVal = round(($min + $max) / 2, 2);
                        $currentVal = $targetValues[$code] ?? $defaultVal;
                        $step = ($max - $min) > 100 ? 5 : (($max - $min) > 10 ? 1 : 0.1);
                    @endphp
                    <div>
                        <label class="block text-xs font-bold text-gray-600 dark:text-slate-300 mb-2">
                            {{ $crit->name }} ({{ $code }})
                            <span class="text-gray-400 dark:text-slate-500 font-normal">
                                @if($code == 'C1') (kkal)
                                @elseif($code == 'C2') (gram)
                                @elseif($code == 'C3') (gram)
                                @elseif($code == 'C4') (gram)
                                @elseif($code == 'C5') (gram)
                                @endif
                            </span>
                        </label>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 w-10 text-right">{{ number_format($min, 0) }}</span>
                            <input type="range" name="target_values[{{ $code }}]" min="{{ $min }}" max="{{ $max }}" step="{{ $step }}" value="{{ $currentVal }}"
                                class="flex-1 h-2 rounded-lg appearance-none cursor-pointer bg-gray-200 dark:bg-slate-700 accent-[#003c90] slider-input"
                                data-code="{{ $code }}"
                                oninput="syncSlider(this)">
                            <span class="text-[10px] font-bold text-gray-400 dark:text-slate-500 w-10">{{ number_format($max, 0) }}</span>
                        </div>
                        <div class="flex items-center gap-3 mt-1.5">
                            <input type="number" name="target_values_display[{{ $code }}]" value="{{ number_format($currentVal, 2) }}" step="{{ $step }}"
                                class="w-24 rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white text-sm text-center font-bold focus:ring-primary focus:border-primary number-input"
                                data-code="{{ $code }}"
                                oninput="syncNumber(this)">
                            <span class="text-[10px] font-semibold text-gray-400 dark:text-slate-500">
                                @if($code == 'C1') kkal
                                @else gram
                                @endif
                            </span>
                        </div>
                    </div>
                @endforeach

                <div class="flex gap-2 pt-2">
                    <button type="submit" name="process" value="1" class="bg-primary hover:bg-primary-hover text-white px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 shadow transition-all duration-200 hover:-translate-y-0.5">
                        <span class="material-symbols-outlined !text-sm">search</span>
                        Cari Rekomendasi
                    </button>
                    <a href="{{ route('admin.recommendation') }}" class="bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-slate-200 border border-gray-200 dark:border-slate-600 px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 shadow-sm transition-all duration-200 hover:-translate-y-0.5">
                        <span class="material-symbols-outlined !text-sm">restart_alt</span>
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(!$isSubmitted)
    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm">
        <div class="p-8 text-center">
            <span class="material-symbols-outlined text-gray-300 dark:text-slate-600 mb-3" style="font-size: 3rem;">info</span>
            <p class="text-sm text-gray-500 dark:text-slate-400 font-medium">Atur kebutuhan gizi di atas, kemudian klik <strong class="text-gray-700 dark:text-slate-200">Cari Rekomendasi</strong> untuk melihat menu paling sesuai.</p>
        </div>
    </div>
    @else
    @if($bestMenu)
    <div class="bg-gradient-to-r from-blue-900 via-primary to-blue-800 rounded-2xl p-6 text-white shadow-lg border border-transparent dark:border-slate-800">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-400/20 border border-amber-400/30 flex items-center justify-center text-amber-300 shrink-0 text-2xl shadow-inner">🏆</div>
                <div>
                    <span class="inline-block px-2.5 py-0.5 bg-amber-400 text-slate-900 font-black text-[10px] uppercase tracking-wider rounded-full shadow-sm">
                        Rekomendasi Menu
                    </span>
                    <h3 class="text-lg font-black tracking-tight text-white mt-2">{{ $bestMenu['code'] }} — {{ $bestMenu['name'] }}</h3>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10 shrink-0 text-center min-w-[120px]">
                <div class="text-[9px] font-bold text-blue-200 uppercase tracking-widest">NILAI PREFERENSI VI</div>
                <div class="text-xl font-black text-amber-300 mt-0.5 tracking-tight">{{ str_replace('.', ',', number_format($bestMenu['score'] * 100, 2)) }}%</div>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 bg-gray-50/40 dark:bg-slate-800/50">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight">Hasil Rekomendasi</h3>
                <span class="badge bg-primary rounded-pill">{{ count($rankingResults) }} menu</span>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-4 py-3.5 text-center" style="width: 6%;">Rank</th>
                        <th class="px-4 py-3.5" style="width: 10%;">Kode</th>
                        <th class="px-4 py-3.5" style="width: 28%;">Nama Menu</th>
                        @foreach($displayCriteriaCodes as $code)
                            <th class="px-4 py-3.5 text-center" style="width: 8%;">{{ $criterias[$code]->name ?? $code }}</th>
                        @endforeach
                        <th class="px-4 py-3.5 text-center" style="width: 12%;">Nilai Preferensi (Vi)</th>
                        <th class="px-4 py-3.5 text-center" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @php
                        $minDistance = null;
                        foreach ($rankingResults as $res) {
                            if (!isset($res['distance']) || $res['distance'] === null) continue;
                            if ($minDistance === null || $res['distance'] < $minDistance) {
                                $minDistance = $res['distance'];
                            }
                        }
                    @endphp
                    @forelse($rankingResults as $res)
                    <tr class="transition-all duration-150 group/row {{ $res['rank'] == 1 ? 'bg-emerald-500/5 dark:bg-emerald-500/5 font-medium' : 'hover:bg-slate-50/60 dark:hover:bg-slate-800/30' }}
                        @if(isset($res['distance']) && $minDistance !== null && $res['distance'] == $minDistance && $minDistance > 0)
                            ! ring-2 !ring-amber-400/50
                        @endif">
                        <td class="px-4 py-3.5 text-center">
                            @if($res['rank'] <= 3)
                                <span class="badge rounded-full {{ $res['rank'] == 1 ? 'bg-amber-100 text-amber-700 dark:bg-amber-400/20 dark:text-amber-300' : ($res['rank'] == 2 ? 'bg-gray-200 text-gray-700 dark:bg-slate-600 dark:text-slate-200' : 'bg-orange-100 text-orange-700 dark:bg-orange-400/20 dark:text-orange-300') }}">
                                    #{{ $res['rank'] }}
                                </span>
                            @else
                                <span class="text-xs font-bold text-gray-500 dark:text-slate-400">#{{ $res['rank'] }}</span>
                            @endif
                            @if(isset($res['distance']) && $minDistance !== null && $res['distance'] == $minDistance && $minDistance > 0)
                                <span class="block text-[9px] font-bold text-amber-500 dark:text-amber-400 mt-0.5">Paling Dekat</span>
                            @endif
                        </td>
                        <td class="px-4 py-3.5 font-bold text-primary dark:text-blue-400 tracking-tight">{{ $res['code'] }}</td>
                        <td class="px-4 py-3.5 font-medium text-xs text-gray-600 dark:text-slate-300 leading-relaxed">{{ $res['name'] }}</td>
                        @foreach($displayCriteriaCodes as $code)
                            <td class="px-4 py-3.5 text-center font-bold text-slate-800 dark:text-slate-200 text-xs">{{ number_format($res[$code] ?? 0, 2) }}</td>
                        @endforeach
                        <td class="px-4 py-3.5 text-center font-bold text-primary dark:text-blue-400">{{ number_format($res['score'], 4) }}</td>
                        <td class="px-4 py-3.5 text-center">
                            <a href="{{ route('admin.result') }}" class="inline-flex items-center gap-1.5 bg-primary/10 hover:bg-primary/20 text-primary dark:text-blue-400 dark:hover:text-blue-300 px-3 py-1.5 rounded-lg text-[11px] font-bold transition-colors">
                                <span class="material-symbols-outlined !text-sm">visibility</span>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 6 + count($displayCriteriaCodes) }}" class="text-center py-10 text-gray-400 dark:text-slate-500">
                            <span class="material-symbols-outlined d-block mb-2" style="font-size: 2rem;">search_off</span>
                            <span class="text-xs font-semibold">Tidak ada data alternatif tersedia.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script>
function syncSlider(input) {
    const code = input.getAttribute('data-code');
    const val = input.value;
    const numInput = document.querySelector('.number-input[data-code="' + code + '"]');
    const hiddenInput = document.querySelector('.hidden-input-' + code);
    if (numInput) numInput.value = parseFloat(val).toFixed(2);
    if (hiddenInput) hiddenInput.value = val;
}

function syncNumber(input) {
    const code = input.getAttribute('data-code');
    const val = parseFloat(input.value);
    const slider = document.querySelector('.slider-input[data-code="' + code + '"]');
    const hiddenInput = document.querySelector('.hidden-input-' + code);
    if (slider && !isNaN(val)) {
        slider.value = val;
    }
    if (hiddenInput && !isNaN(val)) {
        hiddenInput.value = val;
    }
}

document.querySelectorAll('.number-input').forEach(function(input) {
    input.addEventListener('change', function() {
        syncNumber(this);
    });
});
</script>
@endsection
