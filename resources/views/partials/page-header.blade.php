<section class="border-b-8 border-accent bg-ink text-white">
    <div class="mx-auto max-w-6xl px-4 py-14 md:py-20">
        <h1 class="font-display max-w-3xl text-4xl font-extrabold md:text-6xl">{{ $title }}</h1>
        @isset($text)<p class="mt-4 max-w-2xl text-lg text-white/75">{{ $text }}</p>@endisset
    </div>
</section>
