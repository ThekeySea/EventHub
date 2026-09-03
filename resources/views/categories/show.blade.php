<x-public-layout :title="$category->name . ' — EventHub'">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-xs text-neutral-muted">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors">Kategori</a>
                <span>/</span>
                <span class="text-neutral-text font-medium truncate">{{ $category->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Category Header Hero -->
    <section class="bg-gradient-to-b from-white to-neutral-bg border-b border-neutral-border py-10 sm:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-start sm:items-center gap-4 sm:gap-5">
                    @php
                        $slug = strtolower($category->slug);
                    @endphp
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-primary-light text-primary flex items-center justify-center shrink-0 shadow-sm border border-primary/20">
                        @if(str_contains($slug, 'music'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                        @elseif(str_contains($slug, 'educat'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        @elseif(str_contains($slug, 'techno') || str_contains($slug, 'tech'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif(str_contains($slug, 'sport'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        @elseif(str_contains($slug, 'business'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        @elseif(str_contains($slug, 'art'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4 4 4 0 014-4c1.105 0 2 .895 2 2 0 .552.224 1 .5 1s.5-.448.5-1a4.5 4.5 0 019 0c0 1.105-.895 2-2 2h-1a2 2 0 00-2 2c0 1.105-.895 2-2 2h-1z"/></svg>
                        @elseif(str_contains($slug, 'communit'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @elseif(str_contains($slug, 'compet'))
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        @else
                            <svg class="w-8 h-8 sm:w-10 sm:h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-primary-light text-primary text-xs font-semibold mb-2">
                            <span>Kategori</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-poppins text-neutral-text tracking-tight">
                            {{ $category->name }}
                        </h1>
                        <p class="text-sm text-neutral-muted mt-1.5 max-w-2xl leading-relaxed">
                            {{ $category->description ?? 'Daftar seluruh acara dan kegiatan seru dalam kategori ' . $category->name . '.' }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="px-4 py-3 rounded-2xl bg-white border border-neutral-border shadow-xs text-center">
                        <span class="block text-2xl font-bold font-poppins text-primary">{{ $category->events_count }}</span>
                        <span class="text-xs text-neutral-muted font-medium">Event Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Filter Toolbar -->
        <form action="{{ route('categories.show', $category->slug) }}" method="GET" class="bg-white rounded-2xl border border-neutral-border p-4 sm:p-6 shadow-xs mb-6 space-y-4">
            <!-- Search Input -->
            <div class="relative">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari event di kategori {{ $category->name }}..." 
                    class="w-full pl-10 pr-4 py-3 text-sm rounded-xl bg-neutral-bg border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" 
                />
                <svg class="w-4 h-4 text-neutral-muted absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Filter Row -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-5 gap-3">
                <!-- Jenis (Daring, Luring, Hybrid) -->
                <select name="type" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Jenis</option>
                    @foreach($types as $type)
                        <option value="{{ $type->slug }}" {{ request('type') === $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>

                <!-- Format (Seminar, Workshop, Konser, dll) -->
                <select name="format" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Format</option>
                    @foreach($formats as $format)
                        <option value="{{ $format->slug }}" {{ request('format') === $format->slug ? 'selected' : '' }}>{{ $format->name }}</option>
                    @endforeach
                </select>

                <!-- Kota -->
                <select name="city" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Kota</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->slug }}" {{ request('city') === $city->slug ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>

                <!-- Urutkan -->
                <select name="sort" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="soonest" {{ request('sort') === 'soonest' ? 'selected' : '' }}>Waktu Terdekat</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                </select>

                <!-- Submit Button -->
                <button type="submit" class="col-span-2 md:col-span-1 px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </button>
            </div>

            <!-- Active Filters Chips -->
            @if(request()->hasAny(['q', 'type', 'format', 'city', 'date_from', 'date_to']))
                <div class="flex flex-wrap items-center gap-2 pt-3 border-t border-neutral-border/60">
                    <span class="text-xs text-neutral-muted font-medium">Filter aktif:</span>
                    
                    @if(request('q'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            "{{ request('q') }}"
                            <a href="{{ route('categories.show', array_merge(['slug' => $category->slug], request()->except('q'))) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('type'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Jenis: {{ $types->where('slug', request('type'))->first()?->name }}
                            <a href="{{ route('categories.show', array_merge(['slug' => $category->slug], request()->except('type'))) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('format'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Format: {{ $formats->where('slug', request('format'))->first()?->name }}
                            <a href="{{ route('categories.show', array_merge(['slug' => $category->slug], request()->except('format'))) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('city'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Kota: {{ $cities->where('slug', request('city'))->first()?->name }}
                            <a href="{{ route('categories.show', array_merge(['slug' => $category->slug], request()->except('city'))) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    <a href="{{ route('categories.show', $category->slug) }}" class="text-xs text-neutral-muted hover:text-error transition-colors font-medium ml-2">
                        Reset semua
                    </a>
                </div>
            @endif
        </form>

        <!-- Results Count -->
        <div class="mb-6 flex items-center justify-between">
            <p class="text-sm text-neutral-muted">
                Menampilkan <span class="font-semibold text-neutral-text">{{ $events->total() }}</span> {{ Str::plural('event', $events->total()) }} di kategori <span class="font-semibold text-neutral-text">{{ $category->name }}</span>
            </p>
        </div>

        <!-- Events Grid -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($events as $event)
                    <x-event-card
                        :title="$event->title"
                        :category="$event->category->name ?? $category->name"
                        :date="$event->start_at->locale('id')->translatedFormat('l, d M Y')"
                        :location="$event->city->name ?? $event->location ?? 'Online'"
                        :href="route('events.show', $event->slug)"
                        :image="$event->banner_url"
                    />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $events->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-2xl border border-neutral-border py-16 px-6 text-center max-w-lg mx-auto shadow-xs">
                <div class="w-16 h-16 rounded-2xl bg-neutral-bg text-neutral-muted/60 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold font-poppins text-neutral-text mb-1">Tidak Ada Event Ditemukan</h3>
                <p class="text-sm text-neutral-muted mb-6 leading-relaxed">
                    @if(request()->hasAny(['q', 'type', 'format', 'city', 'date_from', 'date_to']))
                        Tidak ada event yang sesuai dengan filter yang kamu pilih di kategori ini. Coba sesuaikan kata kunci atau filter kamu.
                    @else
                        Belum ada event aktif yang tersedia untuk kategori {{ $category->name }} saat ini.
                    @endif
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3">
                    @if(request()->hasAny(['q', 'type', 'format', 'city', 'date_from', 'date_to']))
                        <a href="{{ route('categories.show', $category->slug) }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover transition-colors">
                            Reset Filter
                        </a>
                    @endif
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2.5 rounded-xl bg-neutral-bg text-neutral-text text-sm font-semibold hover:bg-neutral-border transition-colors">
                        Jelajahi Semua Event
                    </a>
                </div>
            </div>
        @endif

    </div>

</x-public-layout>
