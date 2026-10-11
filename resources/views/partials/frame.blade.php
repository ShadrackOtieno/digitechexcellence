{{-- Project card drawn as a browser window. Needs $project (with category and technologies loaded). --}}
<a href="{{ route('work.show', $project->slug) }}" class="frame group flex h-full flex-col overflow-hidden rounded-md border-b-4 border-accent bg-white text-ink">
    <div class="flex items-center gap-1.5 bg-ink px-3 py-2">
        <span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span><span class="h-2 w-2 rounded-full bg-white/30"></span>
        <span class="ml-2 truncate text-xs text-white/70">{{ $project->host }}</span>
    </div>
    <div class="relative aspect-[16/10] overflow-hidden bg-mist">
        @if ($project->cover_url)
            <img src="{{ $project->cover_url }}" alt="{{ $project->title }} screenshot" loading="lazy" class="h-full w-full object-cover object-top transition duration-300 group-hover:scale-[1.03]">
        @else
            <div class="flex h-full items-center justify-center text-ink/30"><x-icon name="image" :size="40" /></div>
        @endif
        @if ($project->isDemo())<span class="absolute right-0 top-0 bg-accent px-3 py-1 text-xs font-bold text-ink">Demo</span>@endif
    </div>
    <div class="flex flex-1 flex-col p-5">
        <p class="text-sm font-bold text-brand">{{ $project->category?->name ?? 'Project' }}</p>
        <h3 class="font-display mt-1 text-xl font-bold">{{ $project->title }}</h3>
        <p class="mt-1.5 line-clamp-2 text-sm text-ink/70">{{ $project->short_description }}</p>
        <p class="mt-auto pt-4 text-sm font-semibold text-ink/60">{{ $project->technologies->take(4)->pluck('name')->implode(', ') }}</p>
    </div>
</a>
