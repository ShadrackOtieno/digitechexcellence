@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    @foreach ([['New inquiries', $newInquiries, 'inbox', 'admin.inquiries.index'], ['Unread messages', $unread, 'mail', 'admin.messages.index'], ['Projects (all)', $projectCount, 'briefcase', 'admin.projects.index'], ['Live on website', $liveCount, 'globe', 'admin.projects.index']] as [$label, $val, $ic, $r])
        <a href="{{ route($r) }}" class="rounded-xl bg-white p-5 hover:shadow-md"><div class="flex items-center justify-between text-ink/60"><span class="text-sm font-semibold">{{ $label }}</span><x-icon :name="$ic" :size="18" /></div><div class="font-display mt-2 text-4xl font-extrabold">{{ $val }}</div></a>
    @endforeach
</div>

@if ($demoCount > 0 || $hiddenTestimonials > 0)
<div class="mt-6 flex gap-3 rounded-xl bg-accent/30 p-5 text-sm">
    <x-icon name="alert-triangle" :size="20" class="mt-0.5" />
    <div>
        @if ($demoCount > 0)<p><strong>{{ $demoCount }} placeholder project{{ $demoCount > 1 ? 's' : '' }}</strong> (marked "demo") {{ $demoCount > 1 ? 'are' : 'is' }} shown on your website. <a href="{{ route('admin.projects.index', ['q' => 'demo']) }}" class="font-bold underline">Replace them with your real work.</a></p>@endif
        @if ($hiddenTestimonials > 0)<p class="mt-1">{{ $hiddenTestimonials }} testimonial{{ $hiddenTestimonials > 1 ? 's are' : ' is' }} hidden. Edit and show only real client quotes.</p>@endif
    </div>
</div>
@endif

<div class="mt-8 grid gap-6 lg:grid-cols-2">
    <section class="rounded-xl bg-white p-5">
        <div class="flex items-center justify-between"><h2 class="font-display text-lg font-bold">Latest inquiries</h2><a href="{{ route('admin.inquiries.index') }}" class="text-sm font-bold text-brand">View all</a></div>
        <ul class="mt-3 divide-y divide-ink/10">
            @forelse ($inquiries as $i)
                <li><a href="{{ route('admin.inquiries.show', $i->id) }}" class="flex items-center justify-between gap-3 py-3 hover:text-brand"><span><strong>{{ $i->name }}</strong><span class="block text-sm text-ink/60">{{ $i->project_type }}</span></span><span class="rounded-full bg-mist px-2.5 py-1 text-xs font-semibold">{{ $i->statusLabel() }}</span></a></li>
            @empty<li class="py-6 text-sm text-ink/60">No inquiries yet.</li>@endforelse
        </ul>
    </section>
    <section class="rounded-xl bg-white p-5">
        <div class="flex items-center justify-between"><h2 class="font-display text-lg font-bold">Latest messages</h2><a href="{{ route('admin.messages.index') }}" class="text-sm font-bold text-brand">View all</a></div>
        <ul class="mt-3 divide-y divide-ink/10">
            @forelse ($messages as $m)
                <li><a href="{{ route('admin.messages.show', $m->id) }}" class="flex items-center justify-between gap-3 py-3 hover:text-brand"><span><strong>{{ $m->subject }}</strong><span class="block text-sm text-ink/60">{{ $m->name }}</span></span>@unless ($m->is_read)<span class="h-2.5 w-2.5 rounded-full bg-accent"></span>@endunless</a></li>
            @empty<li class="py-6 text-sm text-ink/60">No messages yet.</li>@endforelse
        </ul>
    </section>
</div>

<section class="mt-6 rounded-xl bg-white p-5">
    <div class="flex items-center justify-between"><h2 class="font-display text-lg font-bold">Recently added projects</h2><a href="{{ route('admin.projects.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-brand px-4 py-2 text-sm font-bold text-white"><x-icon name="plus" :size="16" /> Add project</a></div>
    <ul class="mt-3 divide-y divide-ink/10">@foreach ($recentProjects as $p)<li><a href="{{ route('admin.projects.edit', $p->id) }}" class="flex justify-between py-3 hover:text-brand"><span class="font-semibold">{{ $p->title }}</span><span class="text-sm text-ink/60">{{ $p->client_name }}</span></a></li>@endforeach</ul>
</section>
@endsection
