<x-public-layout :title="'Explore Events — EventHub'">

    <!-- Header -->
    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold font-poppins text-neutral-text">Explore Events</h1>
            <p class="text-sm text-neutral-muted mt-1">Temukan event yang sesuai dengan minat kamu</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Filter Toolbar -->
        <form action="{{ route('events.index') }}" method="GET" class="bg-white rounded-2xl border border-neutral-border p-4 sm:p-6 shadow-xs mb-6 space-y-4">
            <!-- Search -->
            <div class="relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari event..." class="w-full pl-10 pr-4 py-3 text-sm rounded-xl bg-neutral-bg border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none" />
                <svg class="w-4 h-4 text-neutral-muted absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            <!-- Filter Row -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
                <!-- Tema -->
                <select name="category" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Tema</option>
                    @foreach($themes as $theme)
                        <option value="{{ $theme->slug }}" {{ request('category') === $theme->slug ? 'selected' : '' }}>{{ $theme->name }}</option>
                    @endforeach
                </select>

                <!-- Jenis -->
                <select name="type" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="">Semua Jenis</option>
                    @foreach($types as $type)
                        <option value="{{ $type->slug }}" {{ request('type') === $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>

                <!-- Format -->
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

                <!-- Sort -->
                <select name="sort" class="px-3 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                    <option value="soonest" {{ request('sort') === 'soonest' ? 'selected' : '' }}>Terdekat</option>
                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                </select>

                <!-- Submit -->
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">
                    Filter
                </button>
            </div>

            <!-- Active Filters -->
            @if(request()->hasAny(['q', 'category', 'type', 'format', 'city', 'date_from', 'date_to']))
                <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-neutral-border/60">
                    <span class="text-xs text-neutral-muted font-medium">Filter aktif:</span>
                    
                    @if(request('q'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            "{{ request('q') }}"
                            <a href="{{ route('events.index', request()->except('q')) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('category'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Tema: {{ $themes->where('slug', request('category'))->first()?->name }}
                            <a href="{{ route('events.index', request()->except('category')) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('type'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Jenis: {{ $types->where('slug', request('type'))->first()?->name }}
                            <a href="{{ route('events.index', request()->except('type')) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('format'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Format: {{ $formats->where('slug', request('format'))->first()?->name }}
                            <a href="{{ route('events.index', request()->except('format')) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    @if(request('city'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-primary-light text-primary text-xs font-medium">
                            Kota: {{ $cities->where('slug', request('city'))->first()?->name }}
                            <a href="{{ route('events.index', request()->except('city')) }}" class="ml-0.5 hover:text-primary-hover">×</a>
                        </span>
                    @endif

                    <a href="{{ route('events.index') }}" class="text-xs text-neutral-muted hover:text-error transition-colors font-medium ml-2">
                        Reset semua
                    </a>
                </div>
            @endif
        </form>

        <!-- Results Count -->
        <div class="mb-6">
            <p class="text-sm text-neutral-muted">
                {{ $events->total() }} {{ Str::plural('event', $events->total()) }} ditemukan
            </p>
        </div>

        <!-- Events Grid -->
        @if($events->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($events as $event)
                    <x-event-card
                        :title="$event->title"
                        :category="$event->category->name ?? 'Umum'"
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
            <x-empty-state 
                title="Tidak ada event ditemukan"
                description="Coba ubah filter atau kata kunci pencarian kamu untuk menemukan event lainnya."
                actionText="Reset Filter"
                :actionHref="route('events.index')"
            />
        @endif

    </div>

</x-public-layout>
