<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CredentialController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $search = $request->query('search');

        $credentials = auth()->user()
            ->credentials()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            }))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('credentials.index', compact('credentials', 'category', 'search'));
    }

    public function create(): View
    {
        return view('credentials.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Email,Server,Aplikasi,Pribadi,Lainnya'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        auth()->user()->credentials()->create($validated);

        return redirect()->route('credentials.index')
            ->with('success', 'Kredensial berhasil ditambahkan.');
    }

    public function show(Credential $credential): View
    {
        abort_if($credential->user_id !== auth()->id(), 403);

        return view('credentials.show', compact('credential'));
    }

    public function edit(Credential $credential): View
    {
        abort_if($credential->user_id !== auth()->id(), 403);

        return view('credentials.edit', compact('credential'));
    }

    public function update(Request $request, Credential $credential): RedirectResponse
    {
        abort_if($credential->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:Email,Server,Aplikasi,Pribadi,Lainnya'],
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'url', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $credential->update($validated);

        return redirect()->route('credentials.index')
            ->with('success', 'Kredensial berhasil diperbarui.');
    }

    public function destroy(Credential $credential): RedirectResponse
    {
        abort_if($credential->user_id !== auth()->id(), 403);

        $credential->delete();

        return redirect()->route('credentials.index')
            ->with('success', 'Kredensial berhasil dihapus.');
    }
}
