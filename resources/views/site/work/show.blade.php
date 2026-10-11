@extends('layouts.site')
@section('title', $project->title)
@section('description', $project->short_description)

@section('content')
<section class="border-b-8 border-accent bg-ink text-white">
    <div class="mx-auto max-w-6xl px-4 py-12 md:py-16">
        <a href="{{ route('work.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-accent hover:underline"><x-icon name="arrow-left" :size="16" /> All work</a>
        <p class="mt-5 text-sm font-semibold text-white/70">{{ $project->category?->name ?? 'Project' }} &middot; {{ $project->status_label }}@if ($project->isDemo()) &middot; Demo project @endif</p>
        <h1 class="font-display mt-2 text-4xl font-extrabold md:text-6xl">{{ $project->title }}</h1>
        <p class="mt-4 max-w-2xl text-lg text-white/75">{{ $project->short_description }}</p>
        <div class="mt-7 flex flex-wrap gap-3">
            @if ($project->live_url)<a href="{{ $project->live_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-md bg-accent px-6 py-3 font-bold text-ink">Visit live site <x-icon name="external-link" :size="16" /></a>@endif
            @if ($project->repo_url)<a href="{{ $project->repo_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-md border-2 border-white/60 px-6 py-3 font-bold hover:bg-white/10"><x-icon name="github" :size="16" /> Source</a>@endif
        </div>
    </div>
</section>

<div class="mx-auto grid max-w-6xl gap-12 px-4 pt-12 lg:grid-cols-3">
    <div class="space-y-10 lg:col-span-2">
        @if ($project->cover_url)
            <div class="overflow-hidden rounded-md bg-white shadow-xl">
                <div class="flex items-center gap-1.5 bg-night px-3 py-2"><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="ml-2 text-xs text-white/60">{{ $project->host }}</span></div>
                <img src="{{ $project->cover_url }}" alt="{{ $project->title }} screenshot" class="w-full">
            </div>
        @endif

        @foreach ([['The challenge', $project->challenge], ['What we built', $project->solution]] as [$h, $body])
            @if ($body)<section><h2 class="font-display text-2xl font-extrabold md:text-3xl">{{ $h }}</h2><div class="mt-3 space-y-3 text-lg text-ink/80">@foreach (preg_split('/\R{2,}/', trim($body)) as $para)<p>{{ $para }}</p>@endforeach</div></section>@endif
        @endforeach

        @if (count($project->resultList()))
            <section class="bg-brand p-7 text-white">
                <h2 class="font-display text-2xl font-extrabold">Results</h2>
                <ul class="mt-4 space-y-3">@foreach ($project->resultList() as $r)<li class="flex gap-3"><span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-sm bg-accent text-ink"><x-icon name="check" :size="16" /></span><span>{{ $r }}</span></li>@endforeach</ul>
            </section>
        @endif

        @if ($project->images->isNotEmpty())
            <section x-data="{ src: null }">
                <h2 class="font-display text-2xl font-extrabold md:text-3xl">Screens</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach ($project->images as $img)
                        <button type="button" @click="src = '{{ media_url($img->path) }}'" class="overflow-hidden rounded-md bg-white hover:ring-4 hover:ring-accent"><img src="{{ media_url($img->path) }}" alt="{{ $img->caption ?: $project->title }}" loading="lazy" class="w-full"></button>
                    @endforeach
                </div>
                <div x-show="src" x-cloak @click="src = null" @keydown.escape.window="src = null" class="fixed inset-0 z-50 flex items-center justify-center bg-night/95 p-4">
                    <img :src="src" alt="" class="max-h-full max-w-full rounded-md">
                </div>
            </section>
        @endif

        @foreach ($project->testimonials as $t)
            <figure class="border-t-8 border-accent bg-white p-6"><blockquote class="text-lg">"{{ $t->quote }}"</blockquote><figcaption class="mt-3 text-sm font-semibold">{{ $t->author_name }}@if ($t->company), {{ $t->company }}@endif</figcaption></figure>
        @endforeach
    </div>

    <aside class="lg:col-span-1">
        <div class="sticky top-24 bg-ink p-6 text-white">
            <h2 class="font-display text-lg font-bold text-accent">Project details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @foreach ([['Client', $project->client_name], ['Industry', $project->industry], ['Year', $project->year], ['Our role', $project->role], ['Duration', $project->duration]] as [$k, $v])
                    @if ($v)<div class="flex justify-between gap-4 border-b border-white/15 pb-3"><dt class="text-white/60">{{ $k }}</dt><dd class="text-right font-semibold">{{ $v }}</dd></div>@endif
                @endforeach
            </dl>
            @if ($project->technologies->isNotEmpty())
                <h3 class="mt-5 text-sm font-bold text-accent">Built with</h3>
                <p class="mt-2 text-sm leading-relaxed">@foreach ($project->technologies as $t)<a href="{{ route('work.index', ['tech' => $t->slug]) }}" class="hover:text-accent hover:underline">{{ $t->name }}</a>@unless ($loop->last), @endunless @endforeach</p>
            @endif
            <a href="{{ route('start') }}" class="mt-6 flex items-center justify-center gap-2 rounded-md bg-accent px-5 py-3 font-bold text-ink hover:brightness-95">Build something similar <x-icon name="arrow-right" :size="16" /></a>
        </div>
    </aside>
</div>

@if ($related->isNotEmpty())
<section class="mx-auto max-w-6xl px-4 pt-20">
    <h2 class="font-display text-2xl font-extrabold md:text-3xl">More like this</h2>
    <div class="mt-6 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">@foreach ($related as $rel)@include('partials.frame', ['project' => $rel])@endforeach</div>
</section>
@endif

@if ($next)
<div class="mx-auto mt-12 max-w-6xl px-4">
    <a href="{{ route('work.show', $next->slug) }}" class="flex items-center justify-between bg-brand p-5 font-display text-lg font-bold text-white hover:bg-ink"><span>Next project: {{ $next->title }}</span><x-icon name="arrow-right" :size="20" /></a>
</div>
@endif

@include('partials.cta')
@endsection
