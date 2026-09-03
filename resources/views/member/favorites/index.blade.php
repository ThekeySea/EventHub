@extends('layouts.member')
@php($activeNav = 'favorites')
@php($pageTitle = 'Favorit Saya')
@section('title', 'Favorit Saya')
@section('content')

    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold font-poppins text-neutral-text">My Favorites</h1>
            <p class="text-sm text-neutral-muted mt-1">Event yang Anda simpan</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        @if($favorites->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($favorites as $fav)
                    @php($event = $fav->event)
                    <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden hover:shadow-md transition-shadow group">
                        <!-- Banner -->
                        <div class="h-40 bg-gradient-to-br from-primary/10 via-primary-light to-secondary-light relative overflow-hidden">
                            @if($event->banner)
                                <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-primary/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <!-- Remove favorite button -->
                            <form action="{{ route('events.unfavorite', $event) }}" method="POST" class="absolute top-3 right-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-full bg-error/90 text-white flex items-center justify-center hover:bg-error transition-colors shadow-sm" title="Hapus dari favorit">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </button>
                            </form>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <div class="flex items-center gap-2 mb-2">
                                @if($event->category)
                                    <x-badge variant="primary" size="sm">{{ $event->category->name }}</x-badge>
                                @endif
                                @if($event->eventType)
                                    <span class="text-xs text-info font-medium">{{ $event->eventType->name }}</span>
                                @endif
                            </div>
                            <h3 class="text-base font-bold text-neutral-text font-poppins mb-2 line-clamp-2">
                                <a href="{{ route('events.show', $event->slug) }}" class="hover:text-primary transition-colors">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            <div class="space-y-1 text-xs text-neutral-muted">
                                <p class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $event->start_at ? $event->start_at->locale('id')->translatedFormat('d M Y, H:i') : '—' }}
                                </p>
                                <p class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $event->city->name ?? $event->location ?? 'Online' }}
                                </p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('events.show', $event->slug) }}" class="block text-center px-4 py-2 bg-primary-light text-primary text-sm font-semibold rounded-xl hover:bg-primary hover:text-white transition-colors">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $favorites->links() }}
            </div>
        @else
            <x-empty-state 
                title="Belum ada favorit"
                description="Simpan event menarik yang kamu temukan untuk dilihat kembali nanti!"
                actionText="Jelajahi Event"
                :actionHref="route('events.index')"
            />
        @endif
    </div>

@endsection
