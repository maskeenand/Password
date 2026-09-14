@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto">

    <a href="{{ route('credentials.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 font-medium transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Vault
    </a>

    <div class="flex items-center gap-4 mb-6">
        <div class="w-14 h-14 rounded-2xl gradient-brand flex items-center justify-center text-white text-2xl font-extrabold shadow-lg">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-xl font-bold text-slate-800">{{ auth()->user()->name }}</h1>
            <p class="text-slate-400 text-sm">@{{ auth()->user()->username }}</p>
        </div>
    </div>

    <div class="space-y-5">

        {{-- Update Info --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-700 text-sm">Informasi Akun</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="input-field @error('name') !border-red-300 !bg-red-50 @enderror"
                               required autofocus>
                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm select-none pointer-events-none">@</span>
                            <input id="username" type="text" name="username" value="{{ old('username', $user->username) }}"
                                   class="input-field pl-8 @error('username') !border-red-300 !bg-red-50 @enderror"
                                   required>
                        </div>
                        @error('username')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="btn-primary">Simpan Perubahan</button>
                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 2500)"
                               class="text-sm text-emerald-600 font-medium">
                                ✓ Tersimpan
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h2 class="font-semibold text-slate-700 text-sm">Ubah Password</h2>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Saat Ini</label>
                        <input id="current_password" type="password" name="current_password"
                               class="input-field @error('current_password', 'updatePassword') !border-red-300 !bg-red-50 @enderror"
                               autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru</label>
                        <input id="new_password" type="password" name="password"
                               class="input-field @error('password', 'updatePassword') !border-red-300 !bg-red-50 @enderror"
                               autocomplete="new-password">
                        @error('password', 'updatePassword')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" type="password" name="password_confirmation"
                               class="input-field"
                               autocomplete="new-password">
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" class="btn-primary">Ubah Password</button>
                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition
                               x-init="setTimeout(() => show = false, 2500)"
                               class="text-sm text-emerald-600 font-medium">
                                ✓ Password diperbarui
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Account --}}
        <div class="card overflow-hidden border-red-100">
            <div class="px-6 py-4 border-b border-red-100 bg-red-50">
                <h2 class="font-semibold text-red-700 text-sm">Hapus Akun</h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-slate-500 mb-4">Setelah akun dihapus, semua data termasuk semua kredensial akan hilang permanen.</p>
                <form method="POST" action="{{ route('profile.destroy') }}"
                      onsubmit="return confirm('Yakin hapus akun ini secara permanen? Semua data akan hilang.')">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="del_password" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi dengan Password</label>
                        <input id="del_password" type="password" name="password"
                               class="input-field max-w-xs @error('password', 'userDeletion') !border-red-300 !bg-red-50 @enderror"
                               placeholder="Masukkan password kamu">
                        @error('password', 'userDeletion')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-danger">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Hapus Akun Permanen
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
