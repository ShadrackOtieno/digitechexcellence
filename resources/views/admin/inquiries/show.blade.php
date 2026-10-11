@extends('layouts.admin')
@section('title', 'Inquiry '.$inquiry->reference)

@section('content')
<a href="{{ route('admin.inquiries.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand"><x-icon name="arrow-left" :size="16" /> All inquiries</a>
<div class="grid max-w-5xl gap-6 lg:grid-cols-3">
    <section class="rounded-xl bg-white p-6 lg:col-span-2">
        <h2 class="font-display text-xl font-bold">{{ $inquiry->project_type }}</h2>
        <p class="mt-4 whitespace-pre-line text-ink/80">{{ $inquiry->message }}</p>
        <dl class="mt-6 grid gap-4 border-t border-ink/10 pt-5 text-sm sm:grid-cols-2">
            @foreach ([['Name', $inquiry->name], ['Email', $inquiry->email], ['Phone', $inquiry->phone], ['Company', $inquiry->company], ['Budget', $inquiry->budget], ['Timeline', $inquiry->timeline], ['Received', $inquiry->created_at->format('d M Y, H:i')]] as [$k, $val])
                @if ($val)<div><dt class="text-ink/60">{{ $k }}</dt><dd class="font-semibold">{{ $val }}</dd></div>@endif
            @endforeach
        </dl>
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="mailto:{{ $inquiry->email }}?subject=Re: {{ $inquiry->reference }}" class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-white"><x-icon name="mail" :size="16" /> Reply by email</a>
            @if ($inquiry->phone)<a href="https://wa.me/{{ kenya_phone($inquiry->phone) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full bg-accent px-5 py-2.5 text-sm font-bold"><x-icon name="message-circle" :size="16" /> WhatsApp</a>@endif
        </div>
    </section>
    <form method="POST" action="{{ route('admin.inquiries.update', $inquiry->id) }}" class="rounded-xl bg-white p-6">
        @csrf @method('PUT')
        <label for="status" class="text-sm font-semibold">Status</label>
        <select id="status" name="status" class="mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5">@foreach (\App\Models\Inquiry::STATUSES as $k => $l)<option value="{{ $k }}" @selected($inquiry->status === $k)>{{ $l }}</option>@endforeach</select>
        <label for="admin_notes" class="mt-4 block text-sm font-semibold">Private notes</label>
        <textarea id="admin_notes" name="admin_notes" rows="6" class="mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
        <button class="mt-4 w-full rounded-full bg-brand py-3 font-bold text-white">Save</button>
    </form>
</div>
<form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" class="mt-6" onsubmit="return confirm('Delete this inquiry?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600"><x-icon name="trash" :size="16" /> Delete inquiry</button></form>
@endsection
