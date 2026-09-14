@extends('layouts.app')

@section('title', 'Tambah Server')

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
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-violet-50 to-indigo-50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-indigo-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800">Tambah Server Baru</h2>
                    <p class="text-slate-500 text-xs">Catat IP dan informasi server</p>
                </div>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('servers.store') }}" method="POST">
                @csrf
                @include('servers._form')
                <div class="flex items-center gap-3 mt-7 pt-5 border-t border-slate-100">
                    <button type="submit" class="btn-primary flex-1 justify-center py-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z"/>
                        </svg>
                        Simpan Server
                    </button>
                    <a href="{{ route('servers.index') }}" class="btn-secondary px-6 py-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
