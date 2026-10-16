@php
    $hex = fn ($v, $d) => preg_match('/^#[0-9a-fA-F]{6}$/', (string) $v) ? $v : $d;
    $rgb = function ($h) { $h = ltrim($h, '#'); return hexdec(substr($h, 0, 2)).' '.hexdec(substr($h, 2, 2)).' '.hexdec(substr($h, 4, 2)); };
    $brand = $rgb($hex($site['primary_color'] ?? null, '#1E4BD8'));
    $ink = $rgb($hex($site['ink_color'] ?? null, '#0B1F5C'));
    $accent = $rgb($hex($site['accent_color'] ?? null, '#FFC900'));
    $company = $site['company_name'] ?? 'DevAdvantage';
    $logo = !empty($site['logo']) ? media_url($site['logo']) : asset('images/logo.svg');
    $wa = $site['whatsapp'] ?? '';
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $company)@hasSection('title') | {{ $company }}@endif</title>
    <meta name="description" content="@yield('description', $site['meta_description'] ?? '')">
    <link rel="icon" href="{{ asset('favicon1.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --brand: {{ $brand }}; --ink: {{ $ink }}; --accent: {{ $accent }}; }
        body { font-family: 'Instrument Sans', system-ui, sans-serif; }
        .font-display { font-family: 'Bricolage Grotesque', 'Instrument Sans', sans-serif; letter-spacing: -0.02em; }
        [x-cloak] { display: none !important; }
        .frame { transition: transform .2s ease; }
        .frame:hover { transform: translateY(-4px); }
        :focus-visible { outline: 3px solid rgb(var(--accent)); outline-offset: 2px; }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; scroll-behavior: auto !important; } }
    </style>
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <script>
        tailwind.config = { theme: { extend: { colors: {
            ink: 'rgb(var(--ink) / <alpha-value>)',
            brand: 'rgb(var(--brand) / <alpha-value>)',
            accent: 'rgb(var(--accent) / <alpha-value>)',
            mist: '#E3EAFB',
            night: '#06133B',
        } } } };
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    @stack('head')
</head>
<body class="bg-mist text-ink antialiased">
<a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-accent focus:px-4 focus:py-2 font-semibold">Skip to content</a>

<header x-data="{ open: false }" class="sticky top-0 z-40 bg-ink text-white">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <img src="{{ $logo }}" alt="" class="h-40 w-40 rounded-md">
            {{-- <span class="font-display text-xl font-extrabold">{{ $company }}</span> --}}
        </a>
        <nav class="hidden items-center gap-7 md:flex" aria-label="Main">
            @foreach ([['work.index', 'Work', 'work*'], ['services.index', 'Services', 'services*'], ['about', 'About', 'about'], ['contact', 'Contact', 'contact']] as [$r, $label, $pat])
                <a href="{{ route($r) }}" class="border-b-2 py-5 text-sm font-semibold {{ request()->is($pat) ? 'border-accent text-accent' : 'border-transparent text-white/80 hover:text-white' }}">{{ $label }}</a>
            @endforeach
            <a href="{{ route('start') }}" class="inline-flex items-center gap-2 rounded-md bg-accent px-5 py-2.5 text-sm font-bold text-ink hover:brightness-95">Start a project <x-icon name="arrow-right" :size="16" /></a>
        </nav>
        <button type="button" class="rounded-md p-2 md:hidden" @click="open = !open" :aria-expanded="open" aria-label="Menu">
            <x-icon name="menu" x-show="!open" /><x-icon name="x" x-show="open" x-cloak />
        </button>
    </div>
    <nav x-show="open" x-cloak class="border-t border-white/10 bg-ink px-4 py-3 md:hidden" aria-label="Mobile">
        @foreach ([['work.index', 'Work'], ['services.index', 'Services'], ['about', 'About'], ['contact', 'Contact']] as [$r, $label])
            <a href="{{ route($r) }}" class="block rounded-md px-3 py-3 font-semibold hover:bg-white/10">{{ $label }}</a>
        @endforeach
        <a href="{{ route('start') }}" class="mt-2 flex items-center justify-center gap-2 rounded-md bg-accent px-5 py-3 font-bold text-ink">Start a project <x-icon name="arrow-right" :size="16" /></a>
    </nav>
</header>

@if (session('success'))
    <div class="bg-accent text-ink"><div class="mx-auto flex max-w-6xl items-center gap-2 px-4 py-3 text-sm font-semibold"><x-icon name="check" :size="18" /> {{ session('success') }}</div></div>
@endif

<main id="main">@yield('content')</main>

<footer class="bg-night text-white">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-14 md:grid-cols-4">
        <div class="md:col-span-2">
            <div class="flex items-center gap-2.5"><img src="{{ $logo }}" alt="" class="h-40 w-40 rounded-md"></div>
            <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/70">{{ $site['tagline'] ?? '' }}</p>
            <div class="mt-5 flex gap-3">
                @foreach (['github', 'linkedin', 'twitter', 'instagram'] as $s)
                    @if (!empty($site[$s]))<a href="{{ $site[$s] }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($s) }}" class="rounded-md bg-white/10 p-2.5 hover:bg-accent hover:text-ink"><x-icon :name="$s" :size="18" /></a>@endif
                @endforeach
            </div>
        </div>
        <div>
            <h2 class="font-display text-base font-bold">Services</h2>
            <ul class="mt-4 space-y-2 text-sm text-white/70">
                @foreach ($footerServices as $s)<li><a class="hover:text-accent" href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a></li>@endforeach
            </ul>
        </div>
        <div>
            <h2 class="font-display text-base font-bold">Talk to us</h2>
            <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                @if (!empty($site['email']))<li class="flex items-center gap-2"><x-icon name="mail" :size="16" /><a class="hover:text-accent" href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a></li>@endif
                @if (!empty($site['phone']))<li class="flex items-center gap-2"><x-icon name="phone" :size="16" />{{ $site['phone'] }}</li>@endif
                @if ($wa)<li class="flex items-center gap-2"><x-icon name="message-circle" :size="16" /><a class="hover:text-accent" href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener">WhatsApp</a></li>@endif
                @if (!empty($site['address']))<li class="flex items-center gap-2"><x-icon name="map-pin" :size="16" />{{ $site['address'] }}</li>@endif
            </ul>
        </div>
    </div>
    <div class="border-t border-white/10 py-5 text-center text-xs text-white/50">&copy; {{ date('Y') }} {{ $company }}. All rights reserved.</div>
</footer>
@stack('scripts')
</body>
</html>
