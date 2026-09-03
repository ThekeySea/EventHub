@props([
    'title' => 'Judul Event',
    'category' => 'Kategori',
    'date' => 'Sab, 25 Okt 2026',
    'location' => 'Jakarta',
    'image' => null,
    'href' => '#',
    'favorites' => 0,
    'registrations' => 0,
])

<a href="{{ $href }}" class="group bg-neutral-surface border border-neutral-border rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:border-primary/40 hover:-translate-y-1.5 transition-all duration-300 flex flex-col h-full">
    <!-- Banner Image -->
    <div class="relative aspect-[16/10] overflow-hidden bg-neutral-bg">
        @if($image)
            <img src="{{ $image }}" alt="{{ $title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
        @else
            <div class="w-full h-full flex items-center justify-center text-neutral-muted/30">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-60 group-hover:opacity-40 transition-opacity"></div>
        <!-- Category Badge -->
        <div class="absolute top-3 left-3 z-10">
            <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-primary/90 text-white backdrop-blur-sm">{{ $category }}</span>
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 sm:p-5 flex flex-col flex-1">
        <h3 class="text-sm font-bold text-neutral-text line-clamp-2 group-hover:text-primary transition-colors font-poppins">{{ $title }}</h3>

        <!-- Info Row -->
        <div class="mt-3 space-y-1.5 text-xs text-neutral-muted">
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $date }}</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ $location }}</span>
            </div>
        </div>

        <!-- Stats -->
        <div class="mt-auto pt-3 border-t border-neutral-border/60 flex items-center gap-4 text-xs text-neutral-muted">
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-error" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                {{ $favorites }}
            </span>
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ $registrations }}
            </span>
        </div>
    </div>
</a>
