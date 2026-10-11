@extends('layouts.site')
@section('title', 'About')

@section('content')
@include('partials.page-header', ['title' => 'About '.($site['company_name'] ?? 'DevAdvantage'), 'text' => $site['mission'] ?? null])
<div class="mx-auto max-w-6xl px-4 pt-12">
    <div class="grid gap-12 lg:grid-cols-2">
        <div class="space-y-4 text-lg text-ink/80">@foreach (preg_split('/\R{2,}/', trim($site['about_intro'] ?? '')) as $para)@if ($para)<p>{{ $para }}</p>@endif @endforeach</div>
        <div>
            <h2 class="font-display text-2xl font-extrabold">How we work</h2>
            <ul class="mt-5 space-y-4">
                @foreach (array_filter(array_map('trim', preg_split('/\R/', $site['values'] ?? ''))) as $line)
                    @php [$t, $d] = array_pad(explode(':', $line, 2), 2, ''); @endphp
                    <li class="flex gap-3"><x-icon name="check" :size="20" class="mt-0.5 text-brand" /><span><strong>{{ trim($t) }}</strong>@if (trim($d)) <span class="text-ink/70">{{ trim($d) }}</span>@endif</span></li>
                @endforeach
            </ul>
        </div>
    </div>

    @if ($team->isNotEmpty())
        <h2 class="font-display mt-20 text-3xl font-extrabold">The team</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($team as $m)
                <div class="bg-white p-5">
                    @if ($m->photo)<img src="{{ media_url($m->photo) }}" alt="{{ $m->name }}" class="aspect-square w-full rounded-md object-cover">
                    @else<div class="flex aspect-square w-full items-center justify-center rounded-md bg-brand font-display text-4xl font-extrabold text-white">{{ initials($m->name) }}</div>@endif
                    <h3 class="font-display mt-4 text-lg font-bold">{{ $m->name }}</h3>
                    <p class="text-sm font-semibold text-brand">{{ $m->title }}</p>
                    @if ($m->bio)<p class="mt-2 text-sm text-ink/70">{{ $m->bio }}</p>@endif
                    <div class="mt-3 flex gap-2">
                        @if ($m->github)<a href="{{ $m->github }}" target="_blank" rel="noopener" aria-label="GitHub"><x-icon name="github" :size="18" /></a>@endif
                        @if ($m->linkedin)<a href="{{ $m->linkedin }}" target="_blank" rel="noopener" aria-label="LinkedIn"><x-icon name="linkedin" :size="18" /></a>@endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="font-display mt-20 text-3xl font-extrabold">Our toolbox</h2>
    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($technologies as $group => $items)
            <div class="bg-ink p-5 text-white">
                <h3 class="font-display font-bold text-accent">{{ \App\Models\Technology::GROUPS[$group] ?? ucfirst($group) }}</h3>
                <p class="mt-3 text-sm leading-relaxed text-white/80">{{ $items->pluck('name')->implode(', ') }}</p>
            </div>
        @endforeach
    </div>

    @foreach ($testimonials as $t)
        <figure class="mt-12 border-t-8 border-accent bg-white p-6"><blockquote class="text-lg">"{{ $t->quote }}"</blockquote><figcaption class="mt-3 text-sm font-semibold">{{ $t->author_name }}@if ($t->company), {{ $t->company }}@endif</figcaption></figure>
    @endforeach
</div>
@include('partials.cta')
@endsection
