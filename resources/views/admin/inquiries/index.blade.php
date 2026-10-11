@extends('layouts.admin')
@section('title', 'Inquiries')

@section('content')
<div class="mb-5 flex flex-wrap gap-2">
    <a href="{{ route('admin.inquiries.index') }}" class="rounded-full px-4 py-1.5 text-sm font-semibold {{ !request('status') ? 'bg-brand text-white' : 'bg-white' }}">All</a>
    @foreach (\App\Models\Inquiry::STATUSES as $k => $l)<a href="{{ route('admin.inquiries.index', ['status' => $k]) }}" class="rounded-full px-4 py-1.5 text-sm font-semibold {{ request('status') === $k ? 'bg-brand text-white' : 'bg-white' }}">{{ $l }}</a>@endforeach
</div>
<div class="overflow-x-auto rounded-xl bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-ink/10 text-ink/60"><tr><th class="px-4 py-3 font-semibold">Reference</th><th class="px-4 py-3 font-semibold">From</th><th class="px-4 py-3 font-semibold">Type</th><th class="px-4 py-3 font-semibold">Budget</th><th class="px-4 py-3 font-semibold">Status</th><th class="px-4 py-3 font-semibold">Received</th></tr></thead>
        <tbody class="divide-y divide-ink/10">
            @forelse ($inquiries as $i)
                <tr class="hover:bg-mist/60"><td class="px-4 py-3 font-semibold"><a href="{{ route('admin.inquiries.show', $i->id) }}" class="text-brand hover:underline">{{ $i->reference }}</a></td><td class="px-4 py-3">{{ $i->name }}<div class="text-xs text-ink/60">{{ $i->email }}</div></td><td class="px-4 py-3">{{ $i->project_type }}</td><td class="px-4 py-3">{{ $i->budget ?: 'Not given' }}</td><td class="px-4 py-3"><span class="rounded-full bg-mist px-2.5 py-1 text-xs font-bold">{{ $i->statusLabel() }}</span></td><td class="px-4 py-3 text-ink/60">{{ $i->created_at->format('d M Y') }}</td></tr>
            @empty<tr><td colspan="6" class="px-4 py-10 text-center text-ink/60">No inquiries yet. They appear here when someone fills in the Start a project form.</td></tr>@endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $inquiries->links() }}</div>
@endsection
