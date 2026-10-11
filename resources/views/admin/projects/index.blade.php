@extends('layouts.admin')
@section('title', 'Projects')

@section('content')
<form method="GET" class="mb-5 flex flex-wrap items-center gap-3">
    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search title or client" class="rounded-lg border-2 border-ink/15 bg-white px-3 py-2 text-sm">
    <select name="category" class="rounded-lg border-2 border-ink/15 bg-white px-3 py-2 text-sm"><option value="">All categories</option>@foreach ($categories as $c)<option value="{{ $c->id }}" @selected(request('category') == $c->id)>{{ $c->name }}</option>@endforeach</select>
    <select name="status" class="rounded-lg border-2 border-ink/15 bg-white px-3 py-2 text-sm"><option value="">Any status</option>@foreach (\App\Models\Project::STATUSES as $k => $l)<option value="{{ $k }}" @selected(request('status') === $k)>{{ $l }}</option>@endforeach</select>
    <button class="rounded-lg bg-ink px-4 py-2 text-sm font-bold text-white">Filter</button>
    <a href="{{ route('admin.projects.create') }}" class="ml-auto inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-white"><x-icon name="plus" :size="16" /> Add project</a>
</form>
<div class="overflow-x-auto rounded-xl bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-ink/10 text-ink/60"><tr><th class="px-4 py-3 font-semibold">Project</th><th class="px-4 py-3 font-semibold">Category</th><th class="px-4 py-3 font-semibold">Status</th><th class="px-4 py-3 font-semibold">Shown</th><th class="px-4 py-3"></th></tr></thead>
        <tbody class="divide-y divide-ink/10">
            @forelse ($projects as $p)
                <tr class="hover:bg-mist/60">
                    <td class="px-4 py-3"><div class="flex items-center gap-3">@if ($p->cover_url)<img src="{{ $p->cover_url }}" alt="" class="h-10 w-14 rounded object-cover object-top">@endif<div><div class="font-semibold">{{ $p->title }} @if ($p->is_featured)<x-icon name="star" :size="14" class="inline text-accent" />@endif</div><div class="text-xs text-ink/60">{{ $p->client_name }}</div></div></div></td>
                    <td class="px-4 py-3">{{ $p->category?->name ?? 'None' }}</td>
                    <td class="px-4 py-3">{{ $p->status_label }}</td>
                    <td class="px-4 py-3"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-ink/10 text-ink/60' }}">{{ $p->is_active ? 'Yes' : 'No' }}</span></td>
                    <td class="whitespace-nowrap px-4 py-3 text-right">
                        <a href="{{ route('work.show', $p->slug) }}" target="_blank" class="rounded-lg px-2.5 py-1.5 font-semibold text-ink/60 hover:bg-mist">View</a>
                        <a href="{{ route('admin.projects.edit', $p->id) }}" class="rounded-lg px-2.5 py-1.5 font-semibold text-brand hover:bg-mist">Edit</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $p->id) }}" class="inline" onsubmit="return confirm('Delete this project and its images?')">@csrf @method('DELETE')<button class="rounded-lg px-2.5 py-1.5 font-semibold text-red-600 hover:bg-red-50">Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-10 text-center text-ink/60">No projects found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $projects->links() }}</div>
@endsection
