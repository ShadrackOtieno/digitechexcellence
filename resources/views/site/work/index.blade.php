@extends('layouts.site')
@section('title', 'Our work')
@section('description', 'Web apps, mobile apps and online stores built by '.($site['company_name'] ?? 'DevAdvantage').'.')

@section('content')
@include('partials.page-header', ['title' => 'Our work', 'text' => 'Products we have designed and built. Filter by type or by the tools used.'])

<div class="mx-auto max-w-6xl px-4 py-10">
    <form method="GET" action="{{ route('work.index') }}" class="grid gap-3 md:grid-cols-12">
        <div class="relative md:col-span-5">
            <x-icon name="search" :size="18" class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-ink/40" />
            <input type="search" name="q" value="{{ $term }}" placeholder="Search projects" class="w-full rounded-md border border-ink/30 bg-white py-2.5 pl-10 pr-3 focus:border-brand focus:outline-none">
        </div>
        <select name="tech" class="rounded-md border border-ink/30 bg-white px-3 py-2.5 md:col-span-3" aria-label="Technology">
            <option value="">All technologies</option>
            @foreach ($technologies as $t)<option value="{{ $t->slug }}" @selected($activeTech === $t->slug)>{{ $t->name }}</option>@endforeach
        </select>
        <select name="sort" class="rounded-md border border-ink/30 bg-white px-3 py-2.5 md:col-span-2" aria-label="Sort">
            <option value="">Featured first</option>
            <option value="newest" @selected($sort === 'newest')>Newest</option>
            <option value="oldest" @selected($sort === 'oldest')>Oldest</option>
            <option value="name" @selected($sort === 'name')>Name</option>
        </select>
        @if ($activeCategory)<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
        <button class="rounded-md bg-brand px-4 py-2.5 font-bold text-white md:col-span-2">Apply</button>
    </form>

    <div class="mt-5 flex flex-wrap gap-2">
        <a href="{{ route('work.index', array_filter(['tech' => $activeTech, 'q' => $term, 'sort' => $sort])) }}" class="rounded-md px-4 py-2 text-sm font-semibold {{ !$activeCategory ? 'bg-ink text-white' : 'bg-white hover:bg-accent' }}">All</a>
        @foreach ($categories as $c)
            <a href="{{ route('work.index', array_filter(['category' => $c->slug, 'tech' => $activeTech, 'q' => $term, 'sort' => $sort])) }}" class="rounded-md px-4 py-2 text-sm font-semibold {{ $activeCategory === $c->slug ? 'bg-ink text-white' : 'bg-white hover:bg-accent' }}">{{ $c->name }} <span class="opacity-60">{{ $c->projects_count }}</span></a>
        @endforeach
    </div>

    @if ($projects->isEmpty())
        <div class="mt-10 bg-white p-10 text-center">
            <p class="font-display text-xl font-bold">No projects match those filters.</p>
            <a href="{{ route('work.index') }}" class="mt-3 inline-block font-bold text-brand hover:underline">Clear filters</a>
        </div>
    @else
        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($projects as $project)@include('partials.frame', ['project' => $project])@endforeach
        </div>
        <div class="mt-10">{{ $projects->links() }}</div>
    @endif
</div>

@include('partials.cta')
@endsection
