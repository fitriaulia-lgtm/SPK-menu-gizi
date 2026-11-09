@extends('layouts.user')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">Kelola Parameter Kriteria SPK</h2>
            <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">Daftar kriteria evaluasi menu gizi dengan bobot AHP yang diambil dari database.</p>
        </div>
        <a href="{{ route('criterias.create') }}" class="bg-primary hover:bg-primary-hover text-white px-4 py-2.5 rounded-xl font-bold text-xs flex items-center gap-2 shadow transition-all duration-300 hover:-translate-y-0.5">
            <span class="material-symbols-outlined !text-sm">add</span>
            Tambah Kriteria Baru
        </a>
    </div>

    @if (session('success'))
    <div class="p-4 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/40 rounded-xl flex items-center gap-3 text-xs text-emerald-600 dark:text-emerald-400 font-bold">
        <span class="material-symbols-outlined text-emerald-500">check_circle</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-slate-900/30 text-gray-400 dark:text-slate-400 font-bold text-[10px] uppercase tracking-widest border-b border-gray-200/60 dark:border-slate-700/40">
                        <th class="px-6 py-3.5" style="width: 15%;">Kode</th>
                        <th class="px-6 py-3.5" style="width: 35%;">Nama Parameter</th>
                        <th class="px-6 py-3.5" style="width: 20%;">Atribut</th>
                        <th class="px-6 py-3.5" style="width: 15%;">Bobot AHP</th>
                        <th class="px-6 py-3.5 text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700/40 text-slate-700 dark:text-slate-300">
                    @foreach($criterias as $crit)
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-all duration-150">
                        <td class="px-6 py-4 font-black text-primary dark:text-blue-400 tracking-tight">{{ $crit->code }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-700 dark:text-slate-200">{{ $crit->name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2.5 py-0.5 {{ $crit->attribute === 'benefit' ? 'bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400' : 'bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400' }} font-bold text-[10px] uppercase rounded-full">
                                {{ ucfirst($crit->attribute) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold">
                            @if($crit->weight == (int)$crit->weight)
                                {{ (int)$crit->weight }}
                            @else
                                {{ number_format($crit->weight, 4) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center flex justify-center gap-2">
                            <a href="{{ route('criterias.edit', $crit->id) }}" class="p-1.5 bg-slate-100 hover:bg-primary/10 text-slate-600 hover:text-primary dark:bg-slate-700/50 dark:hover:bg-blue-500/20 dark:text-slate-300 dark:hover:text-blue-400 rounded-lg transition-colors" title="Edit">
                                <span class="material-symbols-outlined !text-base">edit</span>
                            </a>
                            <form action="{{ route('criterias.destroy', $crit->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 bg-slate-100 hover:bg-red-500/10 text-slate-600 hover:text-red-500 dark:bg-slate-700/50 dark:hover:bg-red-500/20 dark:text-slate-300 dark:hover:text-red-400 rounded-lg transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined !text-base">delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
