@extends('layouts.user')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-slate-800/60 border border-gray-200/80 dark:border-slate-700/60 rounded-2xl p-6 shadow-sm">
        <h3 class="font-bold text-slate-800 dark:text-slate-200 text-lg mb-4">Kelola Profil</h3>

        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-emerald-50 text-emerald-700 font-bold">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 font-bold">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full mt-1 px-3 py-2 rounded-lg border text-black" />
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full mt-1 px-3 py-2 rounded-lg border text-black" />
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Password Baru <span class="text-[11px] font-medium text-gray-400">(kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" name="password" class="w-full mt-1 px-3 py-2 rounded-lg border text-black" />
            </div>

            <div>
                <label class="text-xs font-bold text-slate-700 dark:text-slate-300">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 px-3 py-2 rounded-lg border text-black" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
