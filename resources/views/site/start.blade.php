@extends('layouts.site')
@section('title', 'Start a project')

@section('content')
@include('partials.page-header', ['title' => 'Start a project', 'text' => 'Tell us what you want to build. We reply within one working day.'])
<div class="mx-auto max-w-3xl px-4 pb-20 pt-12">
    @if (session('inquiry_ref'))
        <div class="border-t-8 border-accent bg-white p-8 text-center">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-md bg-accent"><x-icon name="check" :size="28" /></span>
            <h2 class="font-display mt-4 text-2xl font-extrabold">Thanks, we have your brief.</h2>
            <p class="mt-2 text-ink/70">Your reference is <strong>{{ session('inquiry_ref') }}</strong>. We will reply by email within one working day.</p>
            <a href="{{ route('work.index') }}" class="mt-5 inline-block font-bold text-brand hover:underline">Browse our work while you wait</a>
        </div>
    @else
    <form method="POST" action="{{ route('start.store') }}" class="space-y-5 border-t-8 border-accent bg-white p-6 md:p-8">
        @csrf
        <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        @php $types = \App\Models\Inquiry::PROJECT_TYPES; $field = 'mt-1 w-full rounded-md border border-ink/30 bg-white px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30'; @endphp
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label for="name" class="text-sm font-semibold">Your name</label><input id="name" name="name" value="{{ old('name') }}" required class="{{ $field }}">@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="email" class="text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" required class="{{ $field }}">@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="phone" class="text-sm font-semibold">Phone (optional)</label><input id="phone" name="phone" value="{{ old('phone') }}" class="{{ $field }}"></div>
            <div><label for="company" class="text-sm font-semibold">Company (optional)</label><input id="company" name="company" value="{{ old('company') }}" class="{{ $field }}"></div>
        </div>
        <div><label for="project_type" class="text-sm font-semibold">What do you need?</label>
            <select id="project_type" name="project_type" required class="{{ $field }}">
                <option value="">Choose one</option>
                @foreach ($types as $t)<option value="{{ $t }}" @selected(old('project_type', $selectedType) === $t)>{{ $t }}</option>@endforeach
            </select>@error('project_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label for="budget" class="text-sm font-semibold">Budget (optional)</label><select id="budget" name="budget" class="{{ $field }}"><option value="">Not sure yet</option>@foreach (\App\Models\Inquiry::BUDGETS as $b)<option @selected(old('budget') === $b)>{{ $b }}</option>@endforeach</select></div>
            <div><label for="timeline" class="text-sm font-semibold">Timeline (optional)</label><select id="timeline" name="timeline" class="{{ $field }}"><option value="">Flexible</option>@foreach (\App\Models\Inquiry::TIMELINES as $b)<option @selected(old('timeline') === $b)>{{ $b }}</option>@endforeach</select></div>
        </div>
        <div><label for="message" class="text-sm font-semibold">Tell us about the project</label><textarea id="message" name="message" rows="7" required class="{{ $field }}" placeholder="What problem are you solving, and who will use it?">{{ old('message') }}</textarea>@error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        <button class="inline-flex items-center gap-2 rounded-md bg-ink px-8 py-3.5 font-bold text-white hover:bg-brand"><x-icon name="send" :size="18" /> Send brief</button>
    </form>
    @endif
</div>
@endsection
