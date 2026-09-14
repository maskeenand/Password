<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Selamat datang!</h1>
        <p class="text-slate-500 text-sm mt-1">Masuk untuk mengakses vault Anda</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-emerald-600 bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Username --}}
        <div>
            <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}"
                   class="input-field @error('username') !border-red-300 !bg-red-50 !ring-red-100 @enderror"
                   placeholder="username kamu" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('username')" class="mt-1.5 text-xs text-red-500" />
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password"
                   class="input-field @error('password') !border-red-300 !bg-red-50 !ring-red-100 @enderror"
                   placeholder="••••••••" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-200 cursor-pointer">
            <label for="remember_me" class="text-sm text-slate-600 cursor-pointer select-none">Ingat saya</label>
        </div>

        <button type="submit" class="btn-primary w-full py-3 text-base mt-1">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/>
            </svg>
            Masuk
        </button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 font-semibold">Daftar sekarang</a>
    </p>
</x-guest-layout>
