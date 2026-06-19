@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <section class="grid grid-cols-12 gap-6">
        <div class="col-span-12 lg:col-span-8 relative overflow-hidden rounded-2xl min-h-[360px] flex items-end border border-transparent dark:border-slate-800/60 shadow-sm group transition-all duration-500 hover:shadow-xl">
            <img alt="Today's Featured Menu" class="absolute inset-0 w-full h-full object-cover transform scale-100 group-hover:scale-105 transition-transform duration-700 ease-out" 
                 src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=1200"/>
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-900/40 to-transparent"></div>
            
            <div class="relative z-10 p-8 w-full flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div class="text-white max-w-lg space-y-2">
                    <span class="inline-block px-3 py-1 bg-emerald-500/20 text-emerald-400 dark:text-emerald-300 font-bold text-[11px] uppercase tracking-widest rounded-full border border-emerald-500/30">
                        Recommended Menu
                    </span>
                    <h2 class="text-2xl font-extrabold tracking-tight text-white drop-shadow-sm">
                        Menu Teratas: <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 to-teal-200">Paket Sehat A10</span>
                    </h2>
                    <p class="text-slate-300 text-xs font-medium leading-relaxed opacity-95">
                        Kombinasi Nasi putih, fried chicken, tahu pong, mix vegetable, dan buah naga memiliki kadar protein terbaik untuk masa pertumbuhan remaja[cite: 325].
                    </p>
                </div>
                <a href="{{ route('admin.result') }}" class="bg-gradient-to-r from-emerald-400 to-teal-500 hover:from-emerald-500 hover:to-teal-600 text-white px-6 py-3 rounded-xl font-extrabold text-xs flex items-center gap-2 shadow-lg transition-all duration-300 hover:-translate-y-0.5 shrink-0 group/btn">
                    <span class="material-symbols-outlined">calculate</span>
                    Hitung & Analisis Menu (TOPSIS)
                    <span class="material-symbols-outlined !text-sm transform group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-4 bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl p-6 flex flex-col shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 group">
            <div class="flex justify-between items-center mb-5">
                <div class="space-y-0.5">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-base tracking-tight">Kriteria Parameter Gizi</h3>
                    <p class="text-[11px] font-semibold text-gray-400 dark:text-slate-400">Prioritas Vektor Bobot (AHP)</p>
                </div>
                <span class="material-symbols-outlined text-primary dark:text-blue-400 transform group-hover:rotate-12 transition-transform duration-300">leaderboard</span>
            </div>
            
            <div class="space-y-3.5 flex-grow flex flex-col justify-center">
                <div class="flex items-center gap-4 p-1.5 rounded-xl">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-gray-100 dark:stroke-slate-700/40" stroke-width="12"></circle>
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-emerald-600 dark:stroke-emerald-400" stroke-width="12" stroke-dasharray="251.2" stroke-dashoffset="173.2" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute text-[10px] font-extrabold text-emerald-600 dark:text-emerald-400">31%</div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-black text-slate-800 dark:text-slate-200 tracking-tight">Protein (C2)</span>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">0.3104</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-1.5 rounded-xl">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-gray-100 dark:stroke-slate-700/40" stroke-width="12"></circle>
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-teal-600 dark:stroke-teal-500" stroke-width="12" stroke-dasharray="251.2" stroke-dashoffset="176.8" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute text-[10px] font-extrabold text-teal-600 dark:text-teal-400">30%</div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-black text-slate-800 dark:text-slate-200 tracking-tight">Serat (C5)</span>
                            <span class="text-xs font-bold text-teal-600 dark:text-teal-400">0.2961</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-1.5 rounded-xl">
                    <div class="relative w-11 h-11 flex items-center justify-center shrink-0">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-gray-100 dark:stroke-slate-700/40" stroke-width="12"></circle>
                            <circle cx="50" cy="50" r="40" fill="none" class="stroke-cyan-600 dark:stroke-cyan-500" stroke-width="12" stroke-dasharray="251.2" stroke-dashoffset="191.2" stroke-linecap="round"></circle>
                        </svg>
                        <div class="absolute text-[10px] font-extrabold text-cyan-600 dark:text-cyan-400">24%</div>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-baseline">
                            <span class="text-xs font-black text-slate-800 dark:text-slate-200 tracking-tight">Karbohidrat (C4)</span>
                            <span class="text-xs font-bold text-cyan-600 dark:text-cyan-400">0.2389</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
        <div class="p-5 border-b border-gray-100 dark:border-slate-700 flex justify-between items-center bg-gray-50/40 dark:bg-slate-800/50">
            <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-tight">Daftar Alternatif Menu Makanan Berpotensi (MBG)</h3>
            <span class="px-2.5 py-0.5 bg-primary/10 dark:bg-blue-500/10 text-primary dark:text-blue-400 rounded-full text-[11px] font-bold">Total: {{ count($alternatives) }} Alternatif Menu</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-6 py-3.5" style="width: 15%;">Kode Menu</th>
                        <th class="px-6 py-3.5" style="width: 65%;">Komposisi Hidangan Sajian</th>
                        <th class="px-6 py-3.5 text-center" style="width: 20%;">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @foreach($alternatives as $alt)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-all duration-150">
                        <td class="px-6 py-4 font-black text-primary dark:text-blue-400 tracking-tight">{{ $alt['code'] }}</td>
                        <td class="px-6 py-4 font-medium text-gray-600 dark:text-slate-300 text-xs leading-relaxed">{{ $alt['name'] }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-block px-2 py-1 bg-green-100 dark:bg-green-950/40 text-green-700 dark:text-green-400 font-bold text-[10px] uppercase rounded">Aktif</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection