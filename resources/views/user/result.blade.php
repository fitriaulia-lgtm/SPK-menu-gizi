@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">Hasil Perangkingan Menu Gizi Seimbang</h2>
            <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">Urutan kelayakan dihitung menggunakan metode gabungan AHP - TOPSIS[cite: 41].</p>
        </div>
    </div>

    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-900 via-primary to-blue-800 p-6 text-white shadow-sm border border-transparent dark:border-slate-800 transition-all duration-300 hover:shadow-md group">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-start gap-5">
                <div class="w-12 h-12 rounded-xl bg-amber-400/20 border border-amber-400/30 flex items-center justify-center text-amber-300 shrink-0 text-2xl shadow-inner">🏆</div>
                <div class="space-y-1">
                    <span class="inline-block px-2.5 py-0.5 bg-amber-400 text-slate-900 font-black text-[10px] uppercase tracking-wider rounded-full shadow-sm">Rekomendasi Utama (Peringkat 1)</span>
                    <h3 class="text-lg font-black tracking-tight text-white mt-1">{{ $bestMenu['code'] }} — {{ $bestMenu['name'] }}</h3>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/10 shrink-0 text-center min-w-[120px]">
                <div class="text-[9px] font-bold text-blue-200 uppercase tracking-widest">Nilai Preferensi Vi</div>
                <div class="text-xl font-black text-amber-300 mt-0.5 tracking-tight">{{ number_format($bestMenu['score'], 4) }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden transition-all duration-300 hover:shadow-md">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-6 py-3.5 text-center" style="width: 12%;">Rank</th>
                        <th class="px-6 py-3.5" style="width: 15%;">Kode Menu</th>
                        <th class="px-6 py-3.5" style="width: 53%;">Komposisi Hidangan Sajian</th>
                        <th class="px-6 py-3.5 text-end pr-8" style="width: 20%;">Nilai Preferensi ($V_i$)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @foreach($rankingResults as $res)
                    <tr class="transition-all duration-150 group/row {{ $res['rank'] == 1 ? 'bg-emerald-500/5 dark:bg-emerald-500/5 font-medium' : 'hover:bg-slate-50/60 dark:hover:bg-slate-800/30' }}">
                        <td class="px-6 py-4 text-center">
                            @if($res['rank'] <= 3)
                                <span class="inline-flex w-6 h-6 items-center justify-center rounded-full text-xs font-black
                                    {{ $res['rank'] == 1 ? 'bg-amber-400 text-slate-950' : '' }}
                                    {{ $res['rank'] == 2 ? 'bg-slate-200 text-slate-900' : '' }}
                                    {{ $res['rank'] == 3 ? 'bg-amber-700 text-white' : '' }}">
                                    {{ $res['rank'] }}
                                </span>
                            @else
                                <span class="text-xs font-bold text-gray-400 dark:text-slate-500">{{ $res['rank'] }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-black text-primary dark:text-blue-400 tracking-tight">{{ $res['code'] }}</td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-600 dark:text-slate-300 group-hover/row:text-slate-950 dark:group-hover/row:text-white transition-colors">
                            {{ $res['name'] }}
                        </td>
                        <td class="px-6 py-4 text-end pr-8 font-black text-slate-800 dark:text-slate-200 tracking-tight {{ $res['rank'] == 1 ? 'text-emerald-600 dark:text-emerald-400' : '' }}">
                            {{ number_format($res['score'], 4) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection