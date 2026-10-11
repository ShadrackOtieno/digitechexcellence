@extends('layouts.site')
@section('title', 'Contact')

@section('content')
@include('partials.page-header', ['title' => 'Contact us', 'text' => 'Questions, quotes or a quick chat about an idea. For a full project brief, use the project form.'])
<div class="mx-auto grid max-w-6xl gap-12 px-4 pb-20 pt-12 lg:grid-cols-5">
    <form method="POST" action="{{ route('contact.store') }}" class="space-y-5 bg-white p-6 lg:col-span-3">
        @csrf
        <div class="hidden" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
        <div class="grid gap-5 sm:grid-cols-2">
            <div><label for="name" class="text-sm font-semibold">Your name</label><input id="name" name="name" value="{{ old('name') }}" required class="mt-1 w-full rounded-md border border-ink/30 bg-white px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">@error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="email" class="text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-md border border-ink/30 bg-white px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">@error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        </div>
        <div><label for="subject" class="text-sm font-semibold">Subject</label><input id="subject" name="subject" value="{{ old('subject') }}" required class="mt-1 w-full rounded-md border border-ink/30 bg-white px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">@error('subject')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        <div><label for="message" class="text-sm font-semibold">Message</label><textarea id="message" name="message" rows="6" required class="mt-1 w-full rounded-md border border-ink/30 bg-white px-3 py-2.5 focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/30">{{ old('message') }}</textarea>@error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
        <button class="inline-flex items-center gap-2 rounded-md bg-brand px-7 py-3 font-bold text-white hover:brightness-110"><x-icon name="send" :size="18" /> Send message</button>
    </form>
    <aside class="space-y-4 lg:col-span-2">
        @foreach ([['mail', 'Email', $site['email'] ?? null, 'mailto:'.($site['email'] ?? '')], ['phone', 'Phone', $site['phone'] ?? null, null], ['map-pin', 'Based in', $site['address'] ?? null, null], ['clock', 'Hours', $site['hours'] ?? null, null]] as [$ic, $label, $val, $href])
            @if ($val)<div class="flex gap-4 bg-ink p-5 text-white"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-accent text-ink"><x-icon :name="$ic" :size="20" /></span><div><div class="text-sm text-white/60">{{ $label }}</div>@if ($href)<a href="{{ $href }}" class="font-semibold hover:text-accent">{{ $val }}</a>@else<div class="font-semibold">{{ $val }}</div>@endif</div></div>@endif
        @endforeach
        @if (!empty($site['whatsapp']))<a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 rounded-md bg-accent px-5 py-3 font-bold text-ink"><x-icon name="message-circle" :size="18" /> Chat on WhatsApp</a>@endif
    </aside>
</div>
@endsection
