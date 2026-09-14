<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Lupa Password?</h1>
        <p class="text-slate-500 text-sm mt-1">Masukkan email Anda untuk menerima link reset password.</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-emerald-600 bg-emerald-50 px-4 py-2.5 rounded-xl border border-emerald-100" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="input-field @error('email') !border-red-300 !bg-red-50 @enderror"
                   placeholder="nama@email.com" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
        </div>
        <button type="submit" class="btn-primary w-full py-3">Kirim Link Reset</button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        <a href="{{ route('login') }}" class="text-primary-600 hover:text-primary-700 font-semibold">← Kembali ke Login</a>
    </p>
</x-guest-layout>
