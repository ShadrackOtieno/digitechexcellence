@extends('layouts.site')
@section('title', 'Services')
@section('description', 'Web apps, mobile apps, e-commerce, integrations and ongoing support.')

@section('content')
@include('partials.page-header', ['title' => 'Services', 'text' => 'From first prototype to hosting and support after launch.'])
<div class="mx-auto grid max-w-6xl gap-4 px-4 pt-12 md:grid-cols-2">
    @foreach ($services as $s)
        <a href="{{ route('services.show', $s->slug) }}" class="group flex gap-5 bg-ink p-7 text-white transition hover:bg-brand">
            <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-accent text-ink"><x-icon :name="$s->icon ?: 'code'" :size="24" /></span>
            <div>
                <h2 class="font-display text-xl font-bold">{{ $s->title }}</h2>
                <p class="mt-2 text-sm text-white/75">{{ $s->summary }}</p>
                <span class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold text-accent">Details <x-icon name="arrow-right" :size="16" /></span>
            </div>
        </a>
    @endforeach
</div>
@include('partials.cta')
@endsection
