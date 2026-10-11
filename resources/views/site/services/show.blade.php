@extends('layouts.site')
@section('title', $service->title)
@section('description', $service->summary)

@section('content')
@include('partials.page-header', ['title' => $service->title, 'text' => $service->summary])
<div class="mx-auto grid max-w-6xl gap-12 px-4 pt-12 lg:grid-cols-3">
    <div class="lg:col-span-2">
        @if ($service->body)<div class="space-y-4 text-lg text-ink/80">@foreach (preg_split('/\R{2,}/', trim($service->body)) as $para)<p>{{ $para }}</p>@endforeach</div>@endif
        @if (count($service->featureList()))
            <h2 class="font-display mt-10 text-2xl font-extrabold">What is included</h2>
            <ul class="mt-4 grid gap-3 sm:grid-cols-2">@foreach ($service->featureList() as $f)<li class="flex gap-3 bg-white p-4"><x-icon name="check" :size="20" class="mt-0.5 text-brand" /><span>{{ $f }}</span></li>@endforeach</ul>
        @endif
    </div>
    <aside>
        <div class="bg-ink p-6 text-white">
            <h2 class="font-display text-lg font-bold">Other services</h2>
            <ul class="mt-3 space-y-2">@foreach ($others as $o)<li><a class="font-semibold text-accent hover:underline" href="{{ route('services.show', $o->slug) }}">{{ $o->title }}</a></li>@endforeach</ul>
            <a href="{{ route('start') }}" class="mt-5 flex items-center justify-center gap-2 rounded-md bg-accent px-5 py-3 font-bold text-ink">Start a project <x-icon name="arrow-right" :size="16" /></a>
        </div>
    </aside>
</div>
@if ($projects->isNotEmpty())
<section class="mx-auto max-w-6xl px-4 pt-20">
    <h2 class="font-display text-2xl font-extrabold">Recent work</h2>
    <div class="mt-6 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">@foreach ($projects as $project)@include('partials.frame', ['project' => $project])@endforeach</div>
</section>
@endif
@include('partials.cta')
@endsection
