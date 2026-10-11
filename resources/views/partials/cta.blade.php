<section class="mt-20 bg-accent text-ink">
    <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-14 md:flex-row md:items-center md:justify-between md:py-16">
        <div class="max-w-2xl">
            <h2 class="font-display text-3xl font-extrabold md:text-5xl">{{ $site['cta_title'] ?? 'Have a product in mind?' }}</h2>
            <p class="mt-3 text-lg text-ink/80">{{ $site['cta_text'] ?? '' }}</p>
        </div>
        <div class="flex shrink-0 flex-wrap gap-3">
            <a href="{{ route('start') }}" class="inline-flex items-center gap-2 rounded-md bg-ink px-6 py-3.5 font-bold text-white hover:bg-brand">Start a project <x-icon name="arrow-right" :size="18" /></a>
            @if (!empty($site['whatsapp']))
                <a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-md border-2 border-ink px-6 py-3.5 font-bold hover:bg-ink hover:text-white"><x-icon name="message-circle" :size="18" /> WhatsApp</a>
            @endif
        </div>
    </div>
</section>
