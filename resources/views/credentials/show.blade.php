@extends('layouts.app')

@section('title', $credential->title)

@section('content')

@php
$categoryMeta = [
    'Email'    => ['icon' => '✉️',  'bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'border' => 'border-blue-200'],
    'Server'   => ['icon' => '🖥️',  'bg' => 'bg-violet-50',  'text' => 'text-violet-700',  'border' => 'border-violet-200'],
    'Aplikasi' => ['icon' => '📱',  'bg' => 'bg-pink-50',    'text' => 'text-pink-700',    'border' => 'border-pink-200'],
    'Pribadi'  => ['icon' => '👤',  'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200'],
    'Lainnya'  => ['icon' => '🔑',  'bg' => 'bg-slate-100',  'text' => 'text-slate-600',   'border' => 'border-slate-200'],
];
$meta = $categoryMeta[$credential->category] ?? $categoryMeta['Lainnya'];
@endphp
<div class="max-w-2xl mx-auto">

    <a href="{{ route('credentials.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 font-medium transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Vault
    </a>

    <div class="card overflow-hidden">

        {{-- Top banner --}}
        <div class="h-2 gradient-brand"></div>

        <div class="p-6">
            {{-- Header --}}
            <div class="flex items-start justify-between gap-4 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl gradient-brand flex items-center justify-center text-white text-2xl font-extrabold shadow-lg shrink-0">
                        {{ strtoupper(substr($credential->title, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800 leading-tight">{{ $credential->title }}</h2>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-semibold {{ $meta['bg'] }} {{ $meta['text'] }} border {{ $meta['border'] }}">
                                {{ $meta['icon'] }} {{ $credential->category }}
                            </span>
                            @if ($credential->url)
                                <a href="{{ $credential->url }}" target="_blank"
                                   class="inline-flex items-center gap-1 text-xs text-primary-600 hover:text-primary-700 hover:underline">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
                                    </svg>
                                    {{ parse_url($credential->url, PHP_URL_HOST) ?? $credential->url }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('credentials.edit', $credential) }}"
                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold border border-amber-200 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                    </svg>
                    Edit
                </a>
            </div>

            {{-- Fields --}}
            <div class="space-y-4">

                {{-- Username --}}
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Username / Email</p>
                        <p class="text-slate-800 font-semibold break-all">{{ $credential->username }}</p>
                    </div>
                    <button onclick="copyText('{{ addslashes($credential->username) }}', this)"
                            class="ml-4 p-2.5 rounded-xl bg-white hover:bg-primary-50 border border-slate-200 text-slate-400 hover:text-primary-600 transition-colors shadow-sm shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                        </svg>
                    </button>
                </div>

                {{-- Password --}}
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Password</p>
                    <div class="flex items-center justify-between gap-3">
                        <p id="pwDisplay" class="mono text-slate-800 font-semibold tracking-widest">••••••••••••</p>
                        <div class="flex items-center gap-2 shrink-0">
                            <button id="togglePw"
                                    class="p-2.5 rounded-xl bg-white hover:bg-primary-50 border border-slate-200 text-slate-400 hover:text-primary-600 transition-colors shadow-sm">
                                <svg id="eyeShow" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                            <button onclick="copyText('{{ addslashes($credential->password) }}', this)"
                                    class="p-2.5 rounded-xl bg-white hover:bg-primary-50 border border-slate-200 text-slate-400 hover:text-primary-600 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                @if ($credential->notes)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-1">Catatan</p>
                    <p class="text-slate-700 text-sm leading-relaxed">{{ $credential->notes }}</p>
                </div>
                @endif

            </div>

            {{-- Timestamps --}}
            <div class="flex items-center justify-between mt-5 pt-4 border-t border-slate-100 text-xs text-slate-400">
                <span>Dibuat {{ $credential->created_at->diffForHumans() }}</span>
                <span>Diperbarui {{ $credential->updated_at->diffForHumans() }}</span>
            </div>

            {{-- Delete --}}
            <form action="{{ route('credentials.destroy', $credential) }}" method="POST" class="mt-4"
                  onsubmit="return confirm('Yakin hapus kredensial ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full py-2.5 justify-center">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                    Hapus Kredensial
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const rawPw = '{{ addslashes($credential->password) }}';
    let revealed = false;

    document.getElementById('togglePw').addEventListener('click', function () {
        revealed = !revealed;
        document.getElementById('pwDisplay').textContent = revealed ? rawPw : '••••••••••••';
        document.getElementById('eyeShow').innerHTML = revealed
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><circle cx="12" cy="12" r="3"/>`;
    });

    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = `<svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>`;
            setTimeout(() => btn.innerHTML = orig, 1500);
        });
    }
</script>
@endpush
