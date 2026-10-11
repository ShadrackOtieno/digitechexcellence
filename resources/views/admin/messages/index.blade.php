@extends('layouts.admin')
@section('title', 'Messages')

@section('content')
<div class="overflow-hidden rounded-xl bg-white">
    <ul class="divide-y divide-ink/10">
        @forelse ($messages as $m)
            <li><a href="{{ route('admin.messages.show', $m->id) }}" class="flex items-center gap-4 px-5 py-4 hover:bg-mist/60"><span class="h-2.5 w-2.5 shrink-0 rounded-full {{ $m->is_read ? 'bg-transparent' : 'bg-accent' }}"></span><span class="min-w-0 flex-1"><span class="block truncate {{ $m->is_read ? '' : 'font-bold' }}">{{ $m->subject }}</span><span class="block truncate text-sm text-ink/60">{{ $m->name }} &middot; {{ $m->email }}</span></span><span class="text-sm text-ink/60">{{ $m->created_at->format('d M') }}</span></a></li>
        @empty<li class="px-5 py-10 text-center text-ink/60">No messages yet.</li>@endforelse
    </ul>
</div>
<div class="mt-5">{{ $messages->links() }}</div>
@endsection
