@extends('layouts.admin')
@section('title', 'Settings')

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="max-w-3xl space-y-6">
    @csrf @method('PUT')
    @foreach ($schema as $group => $fields)
        <section class="rounded-xl bg-white p-6">
            <h2 class="font-display text-lg font-bold">{{ $group }}</h2>
            <div class="mt-4 space-y-5">
                @foreach ($fields as $key => $f)
                    @php [$label, $type] = $f; $help = $f[2] ?? null; $val = old($key, $values[$key] ?? ''); $cls = 'mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none'; @endphp
                    <div>
                        <label for="s_{{ $key }}" class="text-sm font-semibold">{{ $label }}</label>
                        @if ($type === 'textarea')<textarea id="s_{{ $key }}" name="{{ $key }}" rows="4" class="{{ $cls }}">{{ $val }}</textarea>
                        @elseif ($type === 'color')<div class="mt-1 flex items-center gap-3"><input id="s_{{ $key }}" type="color" name="{{ $key }}" value="{{ preg_match('/^#[0-9a-fA-F]{6}$/', $val) ? $val : '#000000' }}" class="h-11 w-16 cursor-pointer rounded border-2 border-ink/15"><span class="text-sm text-ink/60">{{ $val }}</span></div>
                        @elseif ($type === 'image')@if ($val)<img src="{{ media_url($val) }}" alt="" class="mt-2 h-14 rounded-lg">@endif<input id="s_{{ $key }}" type="file" name="{{ $key }}" accept="image/*" class="mt-2 block w-full text-sm">
                        @else<input id="s_{{ $key }}" name="{{ $key }}" value="{{ $val }}" class="{{ $cls }}">@endif
                        @if ($help)<p class="mt-1 text-xs text-ink/60">{{ $help }}</p>@endif
                        @error($key)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
    <button class="rounded-full bg-brand px-8 py-3 font-bold text-white hover:brightness-110">Save settings</button>
</form>
@endsection
