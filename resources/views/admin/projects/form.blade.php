@extends('layouts.admin')
@section('title', $project->exists ? 'Edit project' : 'Add project')

@section('content')
@php $cls = 'mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none'; $v = fn ($k) => old($k, $project->{$k}); @endphp
<form method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" class="max-w-4xl space-y-6">
    @csrf
    @if ($project->exists) @method('PUT') @endif

    <section class="rounded-xl bg-white p-6">
        <h2 class="font-display text-lg font-bold">Basics</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2">
            <div><label class="text-sm font-semibold" for="title">Project title</label><input id="title" name="title" value="{{ $v('title') }}" required class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="client_name">Client name</label><input id="client_name" name="client_name" value="{{ $v('client_name') }}" required class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="category_id">Category</label><select id="category_id" name="category_id" class="{{ $cls }}"><option value="">None</option>@foreach ($categories as $id => $name)<option value="{{ $id }}" @selected((string) $v('category_id') === (string) $id)>{{ $name }}</option>@endforeach</select></div>
            <div><label class="text-sm font-semibold" for="industry">Industry</label><input id="industry" name="industry" value="{{ $v('industry') }}" class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="year">Year</label><input id="year" type="number" name="year" value="{{ $v('year') }}" class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="duration">Duration</label><input id="duration" name="duration" value="{{ $v('duration') }}" placeholder="e.g. 10 weeks" class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="role">Our role</label><input id="role" name="role" value="{{ $v('role') }}" class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="status">Status</label><select id="status" name="status" class="{{ $cls }}">@foreach (\App\Models\Project::STATUSES as $k => $l)<option value="{{ $k }}" @selected($v('status') === $k)>{{ $l }}</option>@endforeach</select></div>
            <div class="sm:col-span-2"><label class="text-sm font-semibold" for="short_description">Short description</label><textarea id="short_description" name="short_description" rows="2" required class="{{ $cls }}">{{ $v('short_description') }}</textarea></div>
            <div><label class="text-sm font-semibold" for="live_url">Live site URL</label><input id="live_url" type="url" name="live_url" value="{{ $v('live_url') }}" class="{{ $cls }}"></div>
            <div><label class="text-sm font-semibold" for="repo_url">Source code URL</label><input id="repo_url" type="url" name="repo_url" value="{{ $v('repo_url') }}" class="{{ $cls }}"></div>
        </div>
    </section>

    <section class="rounded-xl bg-white p-6">
        <h2 class="font-display text-lg font-bold">Case study</h2>
        <div class="mt-4 space-y-5">
            <div><label class="text-sm font-semibold" for="challenge">The challenge</label><textarea id="challenge" name="challenge" rows="4" class="{{ $cls }}">{{ $v('challenge') }}</textarea></div>
            <div><label class="text-sm font-semibold" for="solution">What we built</label><textarea id="solution" name="solution" rows="4" class="{{ $cls }}">{{ $v('solution') }}</textarea></div>
            <div><label class="text-sm font-semibold" for="results">Results (one per line)</label><textarea id="results" name="results" rows="4" class="{{ $cls }}">{{ $v('results') }}</textarea></div>
        </div>
    </section>

    <section class="rounded-xl bg-white p-6">
        <h2 class="font-display text-lg font-bold">Images</h2>
        <div class="mt-4 space-y-5">
            <div>
                <label class="text-sm font-semibold" for="cover_image">Cover screenshot (16:10 works best)</label>
                @if ($project->cover_url)<img src="{{ $project->cover_url }}" alt="" class="mt-2 h-24 rounded-lg border border-ink/10">@endif
                <input id="cover_image" type="file" name="cover_image" accept="image/*" class="mt-2 block w-full text-sm">
            </div>
            <div>
                <label class="text-sm font-semibold" for="gallery">Add gallery images</label>
                <input id="gallery" type="file" name="gallery[]" accept="image/*" multiple class="mt-2 block w-full text-sm">
            </div>
            @if ($project->exists && $project->images->isNotEmpty())
                <div>
                    <p class="text-sm font-semibold">Current gallery (tick to remove)</p>
                    <div class="mt-2 grid grid-cols-3 gap-3 sm:grid-cols-5">
                        @foreach ($project->images as $img)<label class="block text-xs"><img src="{{ media_url($img->path) }}" alt="" class="aspect-video w-full rounded object-cover"><span class="mt-1 flex items-center gap-1.5"><input type="checkbox" name="remove_images[]" value="{{ $img->id }}"> Remove</span></label>@endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <section class="rounded-xl bg-white p-6">
        <h2 class="font-display text-lg font-bold">Technologies</h2>
        @forelse ($technologyGroups as $group => $techs)
            <div class="mt-4"><p class="text-sm font-semibold text-ink/60">{{ \App\Models\Technology::GROUPS[$group] ?? ucfirst($group) }}</p>
                <div class="mt-2 flex flex-wrap gap-2">@foreach ($techs as $t)<label class="flex items-center gap-2 rounded-full bg-mist px-3 py-1.5 text-sm"><input type="checkbox" name="technologies[]" value="{{ $t->id }}" @checked(in_array($t->id, old('technologies', $selectedTech)))> {{ $t->name }}</label>@endforeach</div></div>
        @empty
            <p class="mt-3 text-sm text-ink/60">No technologies yet. <a href="{{ route('admin.technologies.create') }}" class="font-bold text-brand">Add one</a> first.</p>
        @endforelse
    </section>

    <section class="rounded-xl bg-white p-6">
        <h2 class="font-display text-lg font-bold">Display</h2>
        <div class="mt-4 flex flex-wrap items-center gap-6">
            <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_active" value="1" @checked($project->exists ? $project->is_active : true)> Show on website</label>
            <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_featured" value="1" @checked($project->is_featured)> Feature on home page</label>
            <div><label class="text-sm font-semibold" for="sort_order">Order</label> <input id="sort_order" type="number" name="sort_order" value="{{ $v('sort_order') ?? 0 }}" class="ml-2 w-24 rounded-lg border-2 border-ink/15 px-3 py-2"></div>
        </div>
    </section>

    <div class="flex gap-3"><button class="rounded-full bg-brand px-8 py-3 font-bold text-white hover:brightness-110">Save project</button><a href="{{ route('admin.projects.index') }}" class="rounded-full px-7 py-3 font-bold text-ink/70 hover:bg-mist">Cancel</a></div>
</form>
@endsection
