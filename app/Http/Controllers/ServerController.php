<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServerController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $servers = auth()->user()
            ->servers()
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            }))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = auth()->user()->servers()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('servers.index', compact('servers', 'search', 'status', 'counts'));
    }

    public function create(): View
    {
        return view('servers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'string', 'max:45'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'server_user' => ['required', 'string', 'max:100'],
            'server_password' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:VPS,Dedicated,Cloud,VM,Lokal,Lainnya'],
            'os' => ['required', 'in:Ubuntu,Debian,CentOS,Rocky Linux,Windows Server,Proxmox,Lainnya'],
            'status' => ['required', 'in:Aktif,Tidak Aktif,Maintenance'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        auth()->user()->servers()->create($validated);

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil ditambahkan.');
    }

    public function show(Server $server): View
    {
        abort_if($server->user_id !== auth()->id(), 403);

        return view('servers.show', compact('server'));
    }

    public function edit(Server $server): View
    {
        abort_if($server->user_id !== auth()->id(), 403);

        return view('servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server): RedirectResponse
    {
        abort_if($server->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip_address' => ['required', 'string', 'max:45'],
            'port' => ['required', 'integer', 'min:1', 'max:65535'],
            'server_user' => ['required', 'string', 'max:100'],
            'server_password' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:VPS,Dedicated,Cloud,VM,Lokal,Lainnya'],
            'os' => ['required', 'in:Ubuntu,Debian,CentOS,Rocky Linux,Windows Server,Proxmox,Lainnya'],
            'status' => ['required', 'in:Aktif,Tidak Aktif,Maintenance'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $server->update($validated);

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil diperbarui.');
    }

    public function destroy(Server $server): RedirectResponse
    {
        abort_if($server->user_id !== auth()->id(), 403);

        $server->delete();

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil dihapus.');
    }
}
