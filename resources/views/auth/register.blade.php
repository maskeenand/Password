<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Buat akun baru</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar dan mulai simpan password Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}"
                   class="input-field @error('name') !border-red-300 !bg-red-50 @enderror"
                   placeholder="Nama kamu" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500" />
        </div>

        {{-- Username --}}
        <div>
            <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm font-medium select-none pointer-events-none">@</span>
                <input id="username" type="text" name="username" value="{{ old('username') }}"
                       class="input-field pl-8 @error('username') !border-red-300 !bg-red-50 @enderror"
                       placeholder="username_kamu" required autocomplete="username">
            </div>
            <p class="mt-1.5 text-xs text-slate-400">Hanya huruf, angka, dan underscore. Min. 3 karakter.</p>
            <x-input-error :messages="$errors->get('username')" class="mt-1 text-xs text-red-500" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                   class="input-field @error('password') !border-red-300 !bg-red-50 @enderror"
                   placeholder="Min. 8 karakter" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
        </div>

        {{-- Konfirmasi password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation"
                   class="input-field @error('password_confirmation') !border-red-300 !bg-red-50 @enderror"
                   placeholder="Ulangi password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <button type="submit" class="btn-primary w-full py-3 text-base mt-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
            </svg>
            Daftar Sekarang
        </button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Masuk di sini</a>
    </p>
</x-guest-layout>
