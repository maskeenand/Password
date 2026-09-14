@extends('layouts.app')

@section('title', 'Edit — ' . $server->name)

@section('content')
<div class="max-w-2xl mx-auto">

    <a href="{{ route('servers.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-primary-600 font-medium transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Kembali ke Daftar Server
    </a>

    <div class="card overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800">Edit Server</h2>
                    <p class="text-slate-500 text-xs truncate max-w-xs">{{ $server->name }}</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('servers.update', $server) }}" method="POST">
                @csrf
                @method('PUT')
                @include('servers._form')
                <div class="flex items-center gap-3 mt-7 pt-5 border-t border-slate-100">
                    <button type="submit"
                            class="flex-1 justify-center inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition-all shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                        Perbarui Server
                    </button>
                    <a href="{{ route('servers.index') }}" class="btn-secondary px-6 py-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
