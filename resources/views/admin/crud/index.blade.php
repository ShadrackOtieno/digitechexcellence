@extends('layouts.admin')
@section('title', $title)

@section('content')
<div class="mb-5 flex justify-end"><a href="{{ route('admin.'.$route.'.create') }}" class="inline-flex items-center gap-2 rounded-full bg-brand px-5 py-2.5 text-sm font-bold text-white"><x-icon name="plus" :size="16" /> Add {{ strtolower($singular) }}</a></div>
<div class="overflow-x-auto rounded-xl bg-white">
    <table class="w-full text-left text-sm">
        <thead class="border-b border-ink/10 text-ink/60"><tr>@foreach ($columns as $c)<th class="px-4 py-3 font-semibold">{{ $c['label'] }}</th>@endforeach<th class="px-4 py-3"></th></tr></thead>
        <tbody class="divide-y divide-ink/10">
            @forelse ($items as $item)
                <tr class="hover:bg-mist/60">
                    @foreach ($columns as $c)
                        @php $v = data_get($item, $c['key']); $type = $c['type'] ?? 'text'; @endphp
                        <td class="px-4 py-3">
                            @if ($type === 'bool')
                                <span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $v ? 'bg-green-100 text-green-800' : 'bg-ink/10 text-ink/60' }}">{{ $v ? 'Yes' : 'No' }}</span>
                            @elseif ($type === 'image')
                                @if ($v)<img src="{{ media_url($v) }}" alt="" class="h-10 w-10 rounded-lg object-cover">@else<span class="text-ink/30">None</span>@endif
                            @elseif ($type === 'icon')
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-mist text-brand"><x-icon :name="$v ?: 'code'" :size="18" /></span>
                            @else
                                {{ $v }}
                            @endif
                        </td>
                    @endforeach
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.'.$route.'.edit', $item->getKey()) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 font-semibold text-brand hover:bg-mist"><x-icon name="pencil" :size="14" /> Edit</a>
                        <form method="POST" action="{{ route('admin.'.$route.'.destroy', $item->getKey()) }}" class="inline" onsubmit="return confirm('Delete this {{ strtolower($singular) }}?')">@csrf @method('DELETE')<button class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 font-semibold text-red-600 hover:bg-red-50"><x-icon name="trash" :size="14" /> Delete</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="{{ count($columns) + 1 }}" class="px-4 py-10 text-center text-ink/60">Nothing here yet. Use "Add {{ strtolower($singular) }}" to create the first one.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-5">{{ $items->links() }}</div>
@endsection
