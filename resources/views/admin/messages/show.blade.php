@extends('layouts.admin')
@section('title', 'Message')

@section('content')
<a href="{{ route('admin.messages.index') }}" class="mb-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand"><x-icon name="arrow-left" :size="16" /> All messages</a>
<article class="max-w-3xl rounded-xl bg-white p-6">
    <h2 class="font-display text-xl font-bold">{{ $message->subject }}</h2>
    <p class="mt-1 text-sm text-ink/60">{{ $message->name }} &lt;{{ $message->email }}&gt; &middot; {{ $message->created_at->format('d M Y, H:i') }}</p>
    <p class="mt-5 whitespace-pre-line text-ink/80">{{ $message->message }}</p>
    <div class="mt-6 flex items-center gap-4">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-white"><x-icon name="mail" :size="16" /> Reply</a>
        <form method="POST" action="{{ route('admin.messages.destroy', $message->id) }}" onsubmit="return confirm('Delete this message?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1.5 text-sm font-semibold text-red-600"><x-icon name="trash" :size="16" /> Delete</button></form>
    </div>
</article>
@endsection
