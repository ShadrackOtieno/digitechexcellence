@extends('layouts.site')
@section('title', $site['tagline'] ?? 'DevAdvantage')

@section('content')
<section class="overflow-hidden bg-ink text-white">
    <div class="mx-auto grid max-w-6xl items-center gap-14 px-4 py-16 md:grid-cols-12 md:py-24">
        <div class="md:col-span-6">
            <h1 class="font-display text-4xl font-extrabold leading-[1.04] sm:text-5xl lg:text-6xl">{{ $site['hero_title'] ?? 'We build software that gives your business the advantage.' }}</h1>
            <p class="mt-6 max-w-xl text-lg text-white/75">{{ $site['hero_text'] ?? '' }}</p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a href="{{ route('start') }}" class="inline-flex items-center gap-2 rounded-md bg-accent px-7 py-3.5 font-bold text-ink hover:brightness-95">Start a project <x-icon name="arrow-right" :size="18" /></a>
                <a href="{{ route('work.index') }}" class="inline-flex items-center gap-2 rounded-md bg-brand px-7 py-3.5 font-bold text-white hover:brightness-110">See our work</a>
            </div>
        </div>
        <div class="md:col-span-6">
            <div class="relative mx-auto max-w-lg pb-6 pr-6">
                <div class="absolute bottom-0 right-0 h-4/5 w-4/5 bg-accent"></div>
                @php $hp = $heroProjects->values(); @endphp
                @if ($hp->isNotEmpty())
                    <div class="relative overflow-hidden rounded-md bg-white shadow-2xl">
                        <div class="flex items-center gap-1.5 bg-night px-3 py-2"><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="ml-2 truncate text-xs text-white/60">{{ $hp[0]->host }}</span></div>
                        @if ($hp[0]->cover_url)<img src="{{ $hp[0]->cover_url }}" alt="{{ $hp[0]->title }}" class="aspect-[16/10] w-full object-cover object-top">@endif
                    </div>
                @endif
                @if ($hp->count() > 1 && $hp[1]->cover_url)
                    <div class="absolute -left-6 bottom-0 hidden w-2/5 overflow-hidden rounded-md bg-white shadow-2xl sm:block"><img src="{{ $hp[1]->cover_url }}" alt="{{ $hp[1]->title }}" class="aspect-[16/10] w-full object-cover object-top"></div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="bg-accent text-ink">
    <dl class="mx-auto grid max-w-6xl grid-cols-2 divide-x divide-ink/20 px-4 md:grid-cols-3">
        <div class="py-6 pr-4"><dd class="font-display text-4xl font-extrabold">{{ $stats['projects'] }}</dd><dt class="text-sm font-semibold">Projects shown</dt></div>
        <div class="py-6 pl-6 pr-4"><dd class="font-display text-4xl font-extrabold">{{ $stats['technologies'] }}</dd><dt class="text-sm font-semibold">Technologies used</dt></div>
        @if ($stats['since'])<div class="hidden py-6 pl-6 md:block"><dd class="font-display text-4xl font-extrabold">{{ $stats['since'] }}</dd><dt class="text-sm font-semibold">Building since</dt></div>
        @else<div class="hidden py-6 pl-6 md:block"><dd class="font-display text-4xl font-extrabold">{{ $services->count() }}</dd><dt class="text-sm font-semibold">Services</dt></div>@endif
    </dl>
</section>

<section class="bg-brand py-20 text-white">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex items-end justify-between gap-4">
            <h2 class="font-display text-3xl font-extrabold md:text-5xl">Selected work</h2>
            <a href="{{ route('work.index') }}" class="inline-flex items-center gap-1.5 font-bold text-accent hover:underline">All projects <x-icon name="arrow-right" :size="16" /></a>
        </div>
        @if ($featured->isEmpty())
            <p class="mt-8 bg-white/10 p-8">Projects will appear here once they are added in the back office.</p>
        @else
            <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featured->take(6) as $project)@include('partials.frame', ['project' => $project])@endforeach
            </div>
        @endif
    </div>
</section>

<section class="py-20">
    <div class="mx-auto max-w-6xl px-4">
        <h2 class="font-display max-w-2xl text-3xl font-extrabold md:text-5xl">What we build</h2>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $s)
                <a href="{{ route('services.show', $s->slug) }}" class="group bg-ink p-7 text-white transition hover:bg-brand">
                    <span class="inline-flex h-12 w-12 items-center justify-center rounded-md bg-accent text-ink"><x-icon :name="$s->icon ?: 'code'" :size="24" /></span>
                    <h3 class="font-display mt-5 text-xl font-bold">{{ $s->title }}</h3>
                    <p class="mt-2 text-sm text-white/75">{{ $s->summary }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if ($technologies->isNotEmpty())
<section class="bg-night py-16 text-white">
    <div class="mx-auto max-w-6xl px-4">
        <h2 class="font-display text-2xl font-extrabold text-accent">Tools we use</h2>
        <div class="mt-6 flex flex-wrap gap-x-8 gap-y-3 font-display text-2xl font-bold md:text-3xl">
            @foreach ($technologies as $t)<a href="{{ route('work.index', ['tech' => $t->slug]) }}" class="text-white/80 hover:text-accent">{{ $t->name }}</a>@endforeach
        </div>
    </div>
</section>
@endif

@if ($testimonials->isNotEmpty())
<section class="py-20">
    <div class="mx-auto max-w-6xl px-4">
        <h2 class="font-display text-3xl font-extrabold md:text-5xl">What clients say</h2>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ($testimonials as $t)
                <figure class="border-t-8 border-accent bg-white p-6">
                    <blockquote class="text-lg">{{ $t->quote }}</blockquote>
                    <figcaption class="mt-4 text-sm"><strong>{{ $t->author_name }}</strong>@if ($t->author_role || $t->company)<span class="text-ink/60">, {{ collect([$t->author_role, $t->company])->filter()->implode(' at ') }}</span>@endif</figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif

@include('partials.cta')
@endsection
