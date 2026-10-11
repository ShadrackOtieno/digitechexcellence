@extends('layouts.admin')
@section('title', 'My account')

@section('content')
@php $cls = 'mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none'; @endphp
<form method="POST" action="{{ route('admin.account.update') }}" class="max-w-xl space-y-5 rounded-xl bg-white p-6">
    @csrf @method('PUT')
    <div><label for="name" class="text-sm font-semibold">Name</label><input id="name" name="name" value="{{ old('name', $user->name) }}" required class="{{ $cls }}"></div>
    <div><label for="email" class="text-sm font-semibold">Email</label><input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="{{ $cls }}"></div>
    <div class="border-t border-ink/10 pt-5"><p class="text-sm font-semibold">Change password (leave blank to keep the current one)</p></div>
    <div><label for="current_password" class="text-sm font-semibold">Current password</label><input id="current_password" type="password" name="current_password" autocomplete="current-password" class="{{ $cls }}"></div>
    <div><label for="new_password" class="text-sm font-semibold">New password (at least 10 characters)</label><input id="new_password" type="password" name="new_password" autocomplete="new-password" class="{{ $cls }}"></div>
    <div><label for="new_password_confirmation" class="text-sm font-semibold">Repeat new password</label><input id="new_password_confirmation" type="password" name="new_password_confirmation" autocomplete="new-password" class="{{ $cls }}"></div>
    <button class="rounded-full bg-brand px-8 py-3 font-bold text-white hover:brightness-110">Save</button>
</form>
@endsection
