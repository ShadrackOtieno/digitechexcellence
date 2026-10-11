<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex">
    <title>Sign in | {{ $site['company_name'] ?? 'DevAdvantage' }}</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,800&family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Instrument Sans',sans-serif}.font-display{font-family:'Bricolage Grotesque',sans-serif}</style>
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    <script>tailwind.config = { theme: { extend: { colors: { ink: '#0B1F5C', brand: '#1E4BD8', accent: '#FFC900', mist: '#EEF3FF' } } } };</script>
</head>
<body class="flex min-h-screen items-center justify-center bg-ink p-4 text-ink">
    <form method="POST" action="{{ route('admin.login.submit') }}" class="w-full max-w-sm rounded-2xl bg-white p-8 shadow-[8px_8px_0_0_#FFC900]">
        @csrf
        <div class="flex items-center gap-2.5"><img src="{{ asset('images/logo.svg') }}" alt="" class="h-10 w-10 rounded-lg"><span class="font-display text-2xl font-extrabold">{{ $site['company_name'] ?? 'DevAdvantage' }}</span></div>
        <p class="mt-2 text-sm text-ink/60">Back office sign in</p>
        @if ($errors->any())<p class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-800">{{ $errors->first() }}</p>@endif
        <label for="email" class="mt-5 block text-sm font-semibold">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none">
        <label for="password" class="mt-4 block text-sm font-semibold">Password</label>
        <input id="password" type="password" name="password" required class="mt-1 w-full rounded-lg border-2 border-ink/15 px-3 py-2.5 focus:border-brand focus:outline-none">
        <label class="mt-4 flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="rounded"> Keep me signed in</label>
        <button class="mt-6 w-full rounded-full bg-brand py-3 font-bold text-white hover:brightness-110">Sign in</button>
    </form>
</body>
</html>
