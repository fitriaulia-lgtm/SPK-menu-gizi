@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="border-b border-gray-200/60 dark:border-slate-800/60 pb-4">
        <h2 class="text-xl font-extrabold tracking-tight text-slate-800 dark:text-white">Ubah Data Kriteria</h2>
        <p class="text-xs font-semibold text-gray-400 dark:text-slate-400 mt-0.5">Edit spesifikasi atribut kriteria gizi untuk perhitungan TOPSIS.</p>
    </div>

    <form action="{{ route('criterias.update', $criteria->id) }}" method="POST" class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl shadow-sm p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <label for="code" class="text-xs font-bold text-slate-700 dark:text-slate-300">Kode Kriteria</label>
                <input type="text" name="code" id="code" value="{{ old('code', $criteria->code) }}" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-medium text-xs text-slate-800 dark:text-slate-200" required>
                @error('code')
                    <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="attribute" class="text-xs font-bold text-slate-700 dark:text-slate-300">Atribut Kriteria</label>
                <select name="attribute" id="attribute" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-semibold text-xs text-slate-700 dark:text-slate-300" required>
                    <option value="benefit" {{ old('attribute', $criteria->attribute) === 'benefit' ? 'selected' : '' }}>Benefit (Lebih besar lebih baik)</option>
                    <option value="cost" {{ old('attribute', $criteria->attribute) === 'cost' ? 'selected' : '' }}>Cost (Lebih kecil lebih baik)</option>
                </select>
                @error('attribute')
                    <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="space-y-1">
            <label for="name" class="text-xs font-bold text-slate-700 dark:text-slate-300">Nama Parameter Kriteria</label>
            <input type="text" name="name" id="name" value="{{ old('name', $criteria->name) }}" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-medium text-xs text-slate-800 dark:text-slate-200" required>
            @error('name')
                <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1">
            <label for="weight" class="text-xs font-bold text-slate-700 dark:text-slate-300">Bobot AHP</label>
            <input type="number" step="0.0001" min="0" name="weight" id="weight" value="{{ old('weight', $criteria->weight) }}" class="w-full px-4 py-2.5 bg-surface-container-low dark:bg-slate-900 border border-outline-variant dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 font-medium text-xs text-slate-800 dark:text-slate-200" required>
            <p class="text-[11px] text-gray-500 dark:text-slate-400 mt-1">Masukkan bobot AHP (bisa lebih dari 1). Bobot ini akan digunakan dalam perhitungan ranking TOPSIS.</p>
            @error('weight')
                <p class="text-[11px] text-red-500 mt-1 font-semibold">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-slate-700/60">
            <a href="{{ route('criterias.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-hover text-white font-bold text-xs rounded-xl shadow-md transition-all">
                Perbarui Kriteria
            </button>
        </div>
    </form>
</div>
@endsection
