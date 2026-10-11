@extends('layouts.admin')
@section('title', ($item->exists ? 'Edit ' : 'Add ').strtolower($singular))

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.'.$route.'.update', $item->getKey()) : route('admin.'.$route.'.store') }}" class="max-w-3xl rounded-xl bg-white p-6">
    @csrf
    @if ($item->exists) @method('PUT') @endif
    <div class="grid gap-5 sm:grid-cols-2">
        @foreach ($fields as $key => $f)
            @php
                $type = $f['type'] ?? 'text';
                $value = old($key, $item->exists ? $item->{$key} : ($f['default'] ?? null));
                $wide = ($f['wide'] ?? false) || $type === 'textarea' || $type === 'image';
                $cls = 'mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none';
            @endphp
            <div class="{{ $wide ? 'sm:col-span-2' : '' }}">
                @if ($type === 'checkbox')
                    <label class="flex items-center gap-2.5 pt-6 text-sm font-semibold"><input type="checkbox" name="{{ $key }}" value="1" class="h-4 w-4 rounded" @checked((bool) $value)> {{ $f['label'] }}</label>
                @else
                    <label for="f_{{ $key }}" class="text-sm font-semibold">{{ $f['label'] }}</label>
                    @if ($type === 'textarea')
                        <textarea id="f_{{ $key }}" name="{{ $key }}" rows="{{ $f['rows'] ?? 4 }}" class="{{ $cls }}">{{ $value }}</textarea>
                    @elseif ($type === 'select')
                        <select id="f_{{ $key }}" name="{{ $key }}" class="{{ $cls }}">
                            @foreach ($f['options'] as $ov => $ol)<option value="{{ $ov }}" @selected((string) $value === (string) $ov)>{{ $ol }}</option>@endforeach
                        </select>
                    @elseif ($type === 'image')
                        @if ($item->exists && $item->{$key})<img src="{{ media_url($item->{$key}) }}" alt="" class="mt-2 h-20 w-20 rounded-lg object-cover">@endif
                        <input id="f_{{ $key }}" type="file" name="{{ $key }}" accept="image/*" class="mt-2 block w-full text-sm">
                    @else
                        <input id="f_{{ $key }}" type="{{ in_array($type, ['number', 'url', 'email']) ? $type : 'text' }}" name="{{ $key }}" value="{{ $value }}" class="{{ $cls }}">
                    @endif
                @endif
                @if (!empty($f['help']))<p class="mt-1 text-xs text-ink/60">{{ $f['help'] }}</p>@endif
                @error($key)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        @endforeach
    </div>
    <div class="mt-8 flex gap-3">
        <button class="rounded-full bg-brand px-7 py-3 font-bold text-white hover:brightness-110">Save</button>
        <a href="{{ route('admin.'.$route.'.index') }}" class="rounded-full px-7 py-3 font-bold text-ink/70 hover:bg-mist">Cancel</a>
    </div>
</form>
@endsection
