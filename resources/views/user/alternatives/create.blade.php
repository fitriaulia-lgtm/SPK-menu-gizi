@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">Tambah Alternatif Menu Baru</h2>
        <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">Masukkan komposisi hidangan menu sekolah beserta nilai parameter gizinya.</p>
    </div>

    <form action="{{ route('alternatives.store') }}" method="POST" class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-1 space-y-1">
                <label for="code" class="text-xs font-bold text-slate-700 dark:text-slate-300">Kode Menu</label>
                <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="Contoh: A13" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-medium text-xs text-slate-800 dark:text-slate-200" required>
                @error('code')
                    <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-3 space-y-1">
                <label for="name" class="text-xs font-bold text-slate-700 dark:text-slate-300">Komposisi & Nama Menu Hidangan</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: Nasi timbel ayam bakar, tahu tempe goreng, lalapan segar, jeruk manis" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-medium text-xs text-slate-800 dark:text-slate-200" required>
                @error('name')
                    <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-slate-700/60 pt-4">
            <h3 class="text-xs font-extrabold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined !text-base">nutrition</span>
                Kandungan Parameter Gizi
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($criterias as $crit)
                <div class="space-y-1 bg-slate-50/40 dark:bg-slate-900/30 p-3.5 rounded-xl border border-gray-200/50 dark:border-slate-800/80">
                    <label for="values_{{ $crit->id }}" class="text-xs font-black text-slate-800 dark:text-slate-300">
                        {{ $crit->name }} ({{ $crit->code }})
                    </label>
                    <div class="relative group">
                        <input type="number" step="0.01" min="0" name="values[{{ $crit->id }}]" id="values_{{ $crit->id }}" value="{{ old('values.' . $crit->id) }}" placeholder="0.00" class="w-full px-4 py-2 bg-white dark:bg-slate-950 border border-outline-variant dark:border-slate-800 rounded-lg focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-bold text-xs text-slate-800 dark:text-slate-200" required>
                    </div>
                </div>
                @endforeach
            </div>
            @error('values')
                <p class="text-[11px] text-red-500 mt-2 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700/60">
            <a href="{{ route('alternatives.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white font-bold text-xs rounded-xl shadow-md transition-all">
                Simpan Alternatif
            </button>
        </div>
    </form>
</div>
@endsection
