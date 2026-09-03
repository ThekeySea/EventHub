<x-public-layout :title="'Kategori Event — EventHub'">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-xs text-neutral-muted">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span>/</span>
                <span class="text-neutral-text font-medium">Kategori</span>
            </nav>
        </div>
    </div>

    <!-- Header / Hero Section -->
    <section class="bg-gradient-to-b from-white to-neutral-bg border-b border-neutral-border py-10 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-light text-primary text-xs font-semibold mb-4">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Jelajahi Tema Event</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold font-poppins text-neutral-text tracking-tight">
                    Kategori <span class="text-primary">Event</span>
                </h1>
                <p class="text-sm sm:text-base text-neutral-muted mt-3 leading-relaxed">
                    Temukan dan ikuti berbagai event berkualitas sesuai dengan minat, karir, dan passion kamu di seluruh Indonesia.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-bold font-poppins text-neutral-text">Semua Kategori</h2>
                <p class="text-xs sm:text-sm text-neutral-muted mt-0.5">Pilih kategori untuk melihat daftar event terkait</p>
            </div>
            <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-white border border-neutral-border text-neutral-muted shadow-xs">
                {{ $categories->count() }} Kategori
            </span>
        </div>

        @if($categories->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($categories as $category)
                    @php
                        $slug = strtolower($category->slug);
                    @endphp
                    <a href="{{ route('categories.show', $category->slug) }}" class="group relative flex flex-col justify-between bg-white border border-neutral-border rounded-2xl p-6 shadow-xs hover:shadow-xl hover:border-primary/50 hover:-translate-y-1.5 transition-all duration-300">
                        <div>
                            <!-- Icon & Event Count Badge -->
                            <div class="flex items-start justify-between gap-3 mb-5">
                                <div class="w-13 h-13 rounded-2xl bg-primary-light text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white group-hover:scale-105 transition-all duration-300 shadow-xs">
                                    @if(str_contains($slug, 'music'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                    @elseif(str_contains($slug, 'educat'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    @elseif(str_contains($slug, 'techno') || str_contains($slug, 'tech'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @elseif(str_contains($slug, 'sport'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    @elseif(str_contains($slug, 'business'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @elseif(str_contains($slug, 'art'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c1.105 0 2 .895 2 2 0 .552.224 1 .5 1s.5-.448.5-1a4.5 4.5 0 019 0c0 1.105-.895 2-2 2h-1a2 2 0 00-2 2c0 1.105-.895 2-2 2h-1z"/></svg>
                                    @elseif(str_contains($slug, 'communit'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    @elseif(str_contains($slug, 'compet'))
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                    @endif
                                </div>

                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-neutral-bg text-neutral-muted group-hover:bg-primary-light group-hover:text-primary transition-colors">
                                    {{ $category->events_count }} {{ Str::plural('Event', $category->events_count) }}
                                </span>
                            </div>

                            <!-- Name & Description -->
                            <h3 class="text-lg font-bold font-poppins text-neutral-text group-hover:text-primary transition-colors">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-neutral-muted mt-2 line-clamp-2 leading-relaxed">
                                {{ $category->description ?? 'Jelajahi berbagai event dan kegiatan dalam kategori ' . $category->name . '.' }}
                            </p>
                        </div>

                        <!-- Card Footer -->
                        <div class="mt-6 pt-4 border-t border-neutral-border/60 flex items-center justify-between text-xs font-semibold text-primary">
                            <span>Lihat Event</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-neutral-bg text-neutral-muted flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-poppins text-neutral-text mb-1">Belum Ada Kategori</h3>
                <p class="text-sm text-neutral-muted mb-6">Kategori event belum tersedia saat ini. Silakan kembali lagi nanti.</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        @endif
    </div>

</x-public-layout>
