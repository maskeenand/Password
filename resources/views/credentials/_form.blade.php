{{-- Shared form fields for create & edit --}}
<div class="space-y-5">

    <div>
        <label for="title" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Judul / Nama Akun <span class="text-red-400">*</span>
        </label>
        <input type="text" id="title" name="title"
               value="{{ old('title', $credential->title ?? '') }}"
               placeholder="cth: Gmail, Instagram, GitHub…"
               class="input-field @error('title') !border-red-300 !bg-red-50 !ring-red-100 @enderror"
               required>
        @error('title')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block text-sm font-semibold text-slate-700 mb-2">
            Kategori <span class="text-red-400">*</span>
        </label>
        @php
            $categories = [
                'Email'    => ['icon' => '✉️',  'desc' => 'Gmail, Outlook, Yahoo…',     'border' => '#3b82f6', 'bg' => '#eff6ff', 'text' => '#1d4ed8'],
                'Server'   => ['icon' => '🖥️',  'desc' => 'VPS, SSH, cPanel…',          'border' => '#8b5cf6', 'bg' => '#f5f3ff', 'text' => '#6d28d9'],
                'Aplikasi' => ['icon' => '📱',  'desc' => 'Instagram, Spotify, Steam…', 'border' => '#ec4899', 'bg' => '#fdf2f8', 'text' => '#be185d'],
                'Pribadi'  => ['icon' => '👤',  'desc' => 'Catatan pribadi…',            'border' => '#10b981', 'bg' => '#ecfdf5', 'text' => '#065f46'],
                'Lainnya'  => ['icon' => '🔑',  'desc' => 'Lainnya',                    'border' => '#94a3b8', 'bg' => '#f1f5f9', 'text' => '#475569'],
            ];
            $selectedCategory = old('category', $credential->category ?? '');
        @endphp
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5" id="categoryGrid">
            @foreach ($categories as $cat => $meta)
            @php $isSelected = $selectedCategory === $cat; @endphp
            <label class="category-card cursor-pointer"
                   data-border="{{ $meta['border'] }}"
                   data-bg="{{ $meta['bg'] }}"
                   data-text="{{ $meta['text'] }}">
                <input type="radio" name="category" value="{{ $cat }}"
                       class="sr-only" {{ $isSelected ? 'checked' : '' }} required>
                <div class="flex flex-col items-center gap-1 px-3 py-3 rounded-xl border-2 text-center text-sm font-medium transition-all select-none"
                     style="{{ $isSelected
                        ? 'border-color:'.$meta['border'].';background:'.$meta['bg'].';color:'.$meta['text'].';box-shadow:0 1px 6px rgba(0,0,0,.08)'
                        : 'border-color:#e2e8f0;background:#fff;color:#475569' }}">
                    <span class="text-xl leading-none">{{ $meta['icon'] }}</span>
                    <span class="font-semibold">{{ $cat }}</span>
                    <span class="text-[10px] font-normal opacity-70 leading-tight">{{ $meta['desc'] }}</span>
                </div>
            </label>
            @endforeach
        </div>
        @error('category')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Username / Email <span class="text-red-400">*</span>
        </label>
        <input type="text" id="username" name="username"
               value="{{ old('username', $credential->username ?? '') }}"
               placeholder="cth: user@email.com"
               class="input-field @error('username') !border-red-300 !bg-red-50 !ring-red-100 @enderror"
               required>
        @error('username')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Password <span class="text-red-400">*</span>
        </label>
        <div class="relative">
            <input type="password" id="password" name="password"
                   value="{{ old('password', $credential->password ?? '') }}"
                   placeholder="Masukkan password"
                   class="input-field mono pr-11 @error('password') !border-red-300 !bg-red-50 !ring-red-100 @enderror"
                   required>
            <button type="button" id="togglePassword"
                    class="absolute inset-y-0 right-0 px-3.5 flex items-center text-slate-400 hover:text-primary-600 transition-colors">
                <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
        @error('password')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="url" class="block text-sm font-semibold text-slate-700 mb-1.5">
            URL Website
            <span class="text-slate-400 text-xs font-normal">(opsional)</span>
        </label>
        <input type="url" id="url" name="url"
               value="{{ old('url', $credential->url ?? '') }}"
               placeholder="https://example.com"
               class="input-field @error('url') !border-red-300 !bg-red-50 !ring-red-100 @enderror">
        @error('url')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="notes" class="block text-sm font-semibold text-slate-700 mb-1.5">
            Catatan
            <span class="text-slate-400 text-xs font-normal">(opsional)</span>
        </label>
        <textarea id="notes" name="notes" rows="3"
                  placeholder="Catatan tambahan…"
                  class="input-field resize-none @error('notes') !border-red-300 !bg-red-50 !ring-red-100 @enderror">{{ old('notes', $credential->notes ?? '') }}</textarea>
        @error('notes')
            <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
        @enderror
    </div>

</div>

@push('scripts')
<script>
    // Category card selection
    document.querySelectorAll('.category-card').forEach(label => {
        const radio   = label.querySelector('input[type=radio]');
        const card    = label.querySelector('div');
        const border  = label.dataset.border;
        const bg      = label.dataset.bg;
        const text    = label.dataset.text;

        function setActive(active) {
            if (active) {
                card.style.borderColor  = border;
                card.style.background   = bg;
                card.style.color        = text;
                card.style.boxShadow    = '0 2px 8px rgba(0,0,0,.10)';
                card.style.transform    = 'scale(1.03)';
            } else {
                card.style.borderColor  = '#e2e8f0';
                card.style.background   = '#fff';
                card.style.color        = '#475569';
                card.style.boxShadow    = 'none';
                card.style.transform    = 'scale(1)';
            }
        }

        // Initialise on load
        setActive(radio.checked);

        label.addEventListener('click', () => {
            // Deactivate all
            document.querySelectorAll('.category-card').forEach(l => {
                const r = l.querySelector('input[type=radio]');
                const c = l.querySelector('div');
                c.style.borderColor = '#e2e8f0';
                c.style.background  = '#fff';
                c.style.color       = '#475569';
                c.style.boxShadow   = 'none';
                c.style.transform   = 'scale(1)';
                r.checked = false;
            });
            // Activate this one
            radio.checked = true;
            setActive(true);
        });
    });

    // Password toggle
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('password');
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        document.getElementById('eyeIcon').innerHTML = show
            ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`
            : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><circle cx="12" cy="12" r="3"/>`;
    });
</script>
@endpush
