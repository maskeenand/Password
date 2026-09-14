@extends('layouts.app')

@section('title', 'Vault Saya')

@section('content')

@php
$categoryMeta = [
    'Email'    => ['icon' => '✉️',  'color' => 'blue',    'bg' => 'bg-blue-50',    'text' => 'text-blue-700',    'border' => 'border-blue-200',    'dot' => 'bg-blue-400'],
    'Server'   => ['icon' => '🖥️',  'color' => 'violet',  'bg' => 'bg-violet-50',  'text' => 'text-violet-700',  'border' => 'border-violet-200',  'dot' => 'bg-violet-400'],
    'Aplikasi' => ['icon' => '📱',  'color' => 'pink',    'bg' => 'bg-pink-50',    'text' => 'text-pink-700',    'border' => 'border-pink-200',    'dot' => 'bg-pink-400'],
    'Pribadi'  => ['icon' => '👤',  'color' => 'emerald', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-400'],
    'Lainnya'  => ['icon' => '🔑',  'color' => 'slate',   'bg' => 'bg-slate-100',  'text' => 'text-slate-600',   'border' => 'border-slate-200',   'dot' => 'bg-slate-400'],
];

$gradients = [
    'from-violet-500 to-purple-600',
    'from-blue-500 to-indigo-600',
    'from-pink-500 to-rose-600',
    'from-emerald-500 to-teal-600',
    'from-amber-500 to-orange-500',
    'from-cyan-500 to-sky-600',
];

// Count per category for current user
$counts = auth()->user()->credentials()->selectRaw('category, count(*) as total')->groupBy('category')->pluck('total', 'category');
$totalAll = $counts->sum();
@endphp

{{-- Page header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            Vault Saya
            <span class="inline-flex items-center justify-center ml-2 px-2.5 py-0.5 rounded-full bg-primary-100 text-primary-700 text-sm font-semibold">
                {{ $credentials->total() }}
            </span>
        </h1>
        <p class="text-slate-500 text-sm mt-0.5">Semua password tersimpan dengan aman</p>
    </div>
</div>

{{-- Category filter tabs + Search --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">

    {{-- Filter tabs --}}
    <div class="flex items-center gap-2 flex-wrap flex-1">
        <a href="{{ route('credentials.index', array_filter(['search' => $search])) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition-all
                  {{ !$category ? 'bg-slate-800 text-white border-slate-800 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300' }}">
            Semua
            <span class="text-xs {{ !$category ? 'text-slate-300' : 'text-slate-400' }}">{{ $totalAll }}</span>
        </a>
        @foreach ($categoryMeta as $cat => $meta)
        <a href="{{ route('credentials.index', array_filter(['category' => $cat, 'search' => $search])) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition-all
                  {{ $category === $cat
                      ? $meta['bg'].' '.$meta['text'].' '.$meta['border'].' shadow-sm'
                      : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300' }}">
            <span>{{ $meta['icon'] }}</span>
            {{ $cat }}
            <span class="text-xs opacity-60">{{ $counts->get($cat, 0) }}</span>
        </a>
        @endforeach
    </div>

    {{-- Search box --}}
    <form method="GET" action="{{ route('credentials.index') }}" class="flex items-center gap-2 shrink-0 w-full sm:w-72">
        @if ($category)
            <input type="hidden" name="category" value="{{ $category }}">
        @endif
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari judul, username…"
                   class="w-full pl-9 pr-9 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 placeholder-slate-400
                          focus:outline-none focus:border-primary-400 focus:ring-2 focus:ring-primary-100 transition-all">
            @if ($search)
            <a href="{{ route('credentials.index', array_filter(['category' => $category])) }}"
               class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
               title="Hapus pencarian">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
        </div>
    </form>

</div>

@if ($search)
<p class="text-sm text-slate-500 mb-4">
    Hasil pencarian untuk <span class="font-semibold text-slate-700">"{{ $search }}"</span>
    — {{ $credentials->total() }} ditemukan
    <a href="{{ route('credentials.index', array_filter(['category' => $category])) }}"
       class="ml-2 text-primary-600 hover:underline text-xs">Hapus filter</a>
</p>
@endif

@if ($credentials->isEmpty())
    <div class="card p-14 text-center">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-primary-100 to-indigo-100 flex items-center justify-center mb-4 text-3xl">
            {{ $category ? $categoryMeta[$category]['icon'] ?? '🔑' : '🔐' }}
        </div>
        <h3 class="text-base font-bold text-slate-700 mb-1">
            {{ $search
                ? 'Tidak ada hasil untuk "'.$search.'"'
                : ($category ? 'Tidak ada kredensial di kategori '.$category : 'Vault Masih Kosong') }}
        </h3>
        <p class="text-slate-400 text-sm mb-5">
            @if($search) Coba kata kunci lain. @else Belum ada password yang disimpan{{ $category ? ' di sini' : '' }}. @endif
        </p>
        <a href="{{ route('credentials.create') }}" class="btn-primary mx-auto">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Sekarang
        </a>
    </div>

@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach ($credentials as $credential)
        @php
            $meta = $categoryMeta[$credential->category] ?? $categoryMeta['Lainnya'];
            $grad = $gradients[$loop->index % count($gradients)];
        @endphp
        <div class="card card-hover group relative overflow-hidden">
            <div class="h-1 bg-gradient-to-r {{ $grad }}"></div>

            <div class="p-5">
                {{-- Header: avatar + judul saja, tanpa action di sini --}}
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br {{ $grad }} flex items-center justify-center text-white font-bold text-base shadow-md shrink-0">
                        {{ strtoupper(substr($credential->title, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-bold text-slate-800 leading-tight truncate" title="{{ $credential->title }}">{{ $credential->title }}</h3>
                        @if ($credential->url)
                            <a href="{{ $credential->url }}" target="_blank"
                               class="text-xs text-slate-400 hover:text-primary-600 transition-colors truncate block max-w-[200px]">
                                {{ parse_url($credential->url, PHP_URL_HOST) ?? $credential->url }}
                            </a>
                        @else
                            <span class="text-xs text-slate-300">Tanpa URL</span>
                        @endif
                    </div>
                </div>

                {{-- Category badge --}}
                <div class="mb-3">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold {{ $meta['bg'] }} {{ $meta['text'] }} border {{ $meta['border'] }}">
                        {{ $meta['icon'] }} {{ $credential->category }}
                    </span>
                </div>

                <div class="border-t border-slate-100 my-3"></div>

                {{-- Username --}}
                <div class="flex items-center justify-between mb-2.5">
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 mb-0.5">Username</p>
                        <p class="text-sm text-slate-700 font-medium truncate max-w-[180px]">{{ $credential->username }}</p>
                    </div>
                    <button onclick="copyText('{{ addslashes($credential->username) }}', this)"
                            class="w-7 h-7 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 flex items-center justify-center transition-colors shrink-0" title="Salin">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                        </svg>
                    </button>
                </div>

                {{-- Password --}}
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400 mb-0.5">Password</p>
                        <p class="text-sm mono text-slate-700 font-medium tracking-widest" data-pw="{{ $credential->password }}">••••••••</p>
                    </div>
                    <div class="flex items-center gap-1 shrink-0">
                        <button onclick="togglePw(this)"
                                class="w-7 h-7 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 flex items-center justify-center transition-colors" title="Tampilkan">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                        <button onclick="copyText('{{ addslashes($credential->password) }}', this)"
                                class="w-7 h-7 rounded-lg text-slate-400 hover:text-primary-600 hover:bg-primary-50 flex items-center justify-center transition-colors" title="Salin password">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Footer: action buttons — SELALU terlihat di bawah kartu --}}
            <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-1.5">
                <a href="{{ route('credentials.show', $credential) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-primary-50 hover:text-primary-600 border border-slate-200 hover:border-primary-200 transition-colors"
                   title="Lihat Detail">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    Lihat
                </a>
                <a href="{{ route('credentials.edit', $credential) }}"
                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-amber-50 hover:text-amber-600 border border-slate-200 hover:border-amber-200 transition-colors"
                   title="Edit">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                    </svg>
                    Edit
                </a>
                <form action="{{ route('credentials.destroy', $credential) }}" method="POST"
                      onsubmit="return confirm('Hapus {{ addslashes($credential->title) }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-red-50 hover:text-red-500 border border-slate-200 hover:border-red-200 transition-colors"
                            title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if ($credentials->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $credentials->links() }}
        </div>
    @endif
@endif

@endsection

@push('scripts')
<script>
    function togglePw(btn) {
        const card = btn.closest('.card');
        const pwEl = card.querySelector('[data-pw]');
        const hidden = pwEl.textContent.includes('•');
        pwEl.textContent = hidden ? pwEl.dataset.pw : '••••••••';
    }

    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>`;
            setTimeout(() => btn.innerHTML = orig, 1500);
        });
    }
</script>
@endpush
