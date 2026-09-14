@extends('layouts.app')

@section('title', 'Daftar Server IP')

@section('content')

@php
$statusMeta = [
    'Aktif'       => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'dot' => 'bg-emerald-500', 'active' => true],
    'Tidak Aktif' => ['bg' => 'bg-slate-100',  'text' => 'text-slate-500',   'border' => 'border-slate-200',   'dot' => 'bg-slate-400',   'active' => false],
    'Maintenance' => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'border' => 'border-amber-200',   'dot' => 'bg-amber-500',   'active' => false],
];
@endphp

{{-- Page header --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
            Daftar Server IP
            <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full bg-violet-100 text-violet-700 text-sm font-semibold">
                {{ $servers->total() }}
            </span>
        </h1>
        <p class="text-slate-500 text-sm mt-0.5">Kelola semua IP address server Anda</p>
    </div>
    <a href="{{ route('servers.create') }}" class="btn-primary sm:hidden">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Tambah Server
    </a>
</div>

{{-- Filter + Search --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
    {{-- Status filter --}}
    <div class="flex items-center gap-2 flex-wrap flex-1">
        <a href="{{ route('servers.index', array_filter(['search' => $search])) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition-all
                  {{ !$status ? 'bg-slate-800 text-white border-slate-800 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300' }}">
            Semua <span class="text-xs {{ !$status ? 'text-slate-300' : 'text-slate-400' }}">{{ $servers->total() + ($servers->total() != $counts->sum() ? $counts->sum() - $servers->total() : 0) }}</span>
        </a>
        @foreach ($statusMeta as $st => $m)
        <a href="{{ route('servers.index', array_filter(['status' => $st, 'search' => $search])) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold border transition-all
                  {{ $status === $st ? $m['bg'].' '.$m['text'].' '.$m['border'].' shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-300' }}">
            <span class="w-2 h-2 rounded-full {{ $m['dot'] }}"></span>
            {{ $st }}
            <span class="text-xs opacity-60">{{ $counts->get($st, 0) }}</span>
        </a>
        @endforeach
    </div>

    {{-- Search --}}
    <form method="GET" action="{{ route('servers.index') }}" class="flex items-center shrink-0 w-full sm:w-64">
        @if ($status)
            <input type="hidden" name="status" value="{{ $status }}">
        @endif
        <div class="relative w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama, IP, lokasi…"
                   class="w-full pl-9 pr-9 py-2 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 placeholder-slate-400
                          focus:outline-none focus:border-violet-400 focus:ring-2 focus:ring-violet-100 transition-all">
            @if ($search)
            <a href="{{ route('servers.index', array_filter(['status' => $status])) }}"
               class="absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </a>
            @endif
        </div>
    </form>
</div>

@if ($servers->isEmpty())
    <div class="card p-14 text-center">
        <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-br from-violet-100 to-indigo-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
            </svg>
        </div>
        <h3 class="text-base font-bold text-slate-700 mb-1">
            @if ($search) Tidak ada hasil untuk "{{ $search }}"
            @elseif ($status) Tidak ada server dengan status {{ $status }}
            @else Belum ada server tercatat
            @endif
        </h3>
        <p class="text-slate-400 text-sm mb-5">Tambahkan server pertama Anda sekarang.</p>
        <a href="{{ route('servers.create') }}" class="btn-primary mx-auto">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Server
        </a>
    </div>

@else
    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">Nama Server</th>
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">IP Address</th>
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">Port</th>
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">Tipe / OS</th>
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">Lokasi</th>
                        <th class="text-left px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-400">Status</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($servers as $server)
                    @php $sm = $statusMeta[$server->status] ?? $statusMeta['Tidak Aktif']; @endphp
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center text-white shrink-0 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-slate-800">{{ $server->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2">
                                <span class="mono font-medium text-violet-700 bg-violet-50 px-2.5 py-1 rounded-lg border border-violet-100 text-xs">{{ $server->ip_address }}</span>
                                <button onclick="copyText('{{ $server->ip_address }}', this)"
                                        class="opacity-0 group-hover:opacity-100 text-slate-400 hover:text-violet-600 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0013.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 01-.75.75H9a.75.75 0 01-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 01-2.25 2.25H6.75A2.25 2.25 0 014.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 011.927-.184"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="mono text-slate-600 text-xs bg-slate-100 px-2 py-1 rounded-lg">:{{ $server->port }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div>
                                <span class="text-slate-700 font-medium">{{ $server->type }}</span>
                                <span class="text-slate-400 text-xs block">{{ $server->os }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-500 text-xs">
                            {{ $server->location ?? '—' }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $sm['bg'] }} {{ $sm['text'] }} border {{ $sm['border'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $sm['dot'] }} {{ $server->status === 'Aktif' ? 'animate-pulse' : '' }}"></span>
                                {{ $server->status }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('servers.show', $server) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-violet-50 hover:text-violet-600 border border-slate-200 hover:border-violet-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('servers.edit', $server) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-amber-50 hover:text-amber-600 border border-slate-200 hover:border-amber-200 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('servers.destroy', $server) }}" method="POST"
                                      onsubmit="return confirm('Hapus server {{ addslashes($server->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 bg-white hover:bg-red-50 hover:text-red-500 border border-slate-200 hover:border-red-200 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($servers->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $servers->links() }}
        </div>
    @endif
@endif

@endsection

@push('scripts')
<script>
    function copyText(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const orig = btn.innerHTML;
            btn.innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>`;
            setTimeout(() => btn.innerHTML = orig, 1500);
        });
    }
</script>
@endpush
