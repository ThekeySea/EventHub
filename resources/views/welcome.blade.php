<x-public-layout>

    {{-- SKELETON LOADING --}}
    <div x-data="{ loading: true }" x-init="setTimeout(() => { loading = false }, 1500)">
        <div x-show="loading" x-cloak class="fixed inset-0 z-[9999] bg-white">
            <div class="animate-pulse max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24">
                <div class="h-10 bg-primary-light/50 rounded-xl w-1/2 mb-4"></div>
                <div class="h-6 bg-neutral-border/50 rounded-lg w-1/3 mb-8"></div>
                <div class="flex gap-3 mb-16">
                    <div class="h-12 w-36 bg-primary-light/60 rounded-xl"></div>
                    <div class="h-12 w-36 bg-neutral-border/40 rounded-xl"></div>
                </div>
                <div class="bg-neutral-bg rounded-2xl p-5 mb-16 max-w-5xl">
                    <div class="h-12 bg-neutral-border/40 rounded-xl mb-3"></div>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="h-10 bg-neutral-border/30 rounded-xl"></div>
                        <div class="h-10 bg-neutral-border/30 rounded-xl"></div>
                        <div class="h-10 bg-neutral-border/30 rounded-xl"></div>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    @for($s = 0; $s < 3; $s++)
                    <div class="rounded-2xl border border-neutral-border overflow-hidden">
                        <div class="h-48 bg-primary-light/40"></div>
                        <div class="p-4 space-y-3">
                            <div class="h-4 bg-neutral-border/50 rounded w-3/4"></div>
                            <div class="h-3 bg-neutral-border/30 rounded w-1/2"></div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{-- HERO --}}
    <section class="relative min-h-screen flex items-center" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1920&h=1080&fit=crop'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 overflow-hidden">
    
    
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16 w-full">
            <div class="max-w-3xl" data-aos="fade-up">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-poppins text-white leading-tight">
                    Temukan Event<br><span class="text-primary">Terbaik</span> Untukmu
                </h1>
                <p class="mt-6 text-lg text-white/80 leading-relaxed">Jelajahi ribuan event menarik di seluruh Indonesia.</p>
            </div>
            <div class="mt-12 max-w-5xl" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('events.index') }}" method="GET" class="bg-white rounded-2xl shadow-xl border border-neutral-border/60 p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1 relative">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="q" placeholder="Cari event, workshop, seminar..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-neutral-border bg-neutral-bg/50 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <button type="submit" class="px-8 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-all shadow-sm">Cari</button>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-4">
                        <select name="category" class="px-3 py-2 text-xs rounded-lg border border-neutral-border bg-white focus:border-primary outline-none transition-all"><option value="">Semua Tema</option>@foreach($themes as $theme)<option value="{{ $theme->slug }}">{{ $theme->name }}</option>@endforeach</select>
                        <select name="format" class="px-3 py-2 text-xs rounded-lg border border-neutral-border bg-white focus:border-primary outline-none transition-all"><option value="">Semua Format</option>@foreach($formats as $format)<option value="{{ $format->slug }}">{{ $format->name }}</option>@endforeach</select>
                        <select name="city" class="px-3 py-2 text-xs rounded-lg border border-neutral-border bg-white focus:border-primary outline-none transition-all"><option value="">Semua Kota</option>@foreach($cities as $city)<option value="{{ $city->slug }}">{{ $city->name }}</option>@endforeach</select>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- TEMA POPULER --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Tema Populer</h2>
                <p class="text-sm text-neutral-muted mt-2">Kategori dengan event terbanyak</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @forelse($popularThemes as $theme)
                    <a href="{{ route('events.index', ['category' => $theme->slug]) }}" class="group p-5 rounded-2xl border border-neutral-border bg-white hover:border-primary/40 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="w-12 h-12 mx-auto rounded-xl bg-primary-light text-primary flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-neutral-text group-hover:text-primary transition-colors">{{ $theme->name }}</p>
                        <p class="text-xs text-neutral-muted mt-1">{{ $theme->events_count ?? 0 }} event</p>
                    </a>
                @empty
                    <p class="col-span-full text-center text-neutral-muted">Belum ada tema populer.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PILIHAN ACARA --}}
    @php
        $typeDescriptions = [
            'luring' => 'Acara langsung di lokasi fisik. Bertemu langsung dengan peserta, jaringan, dan pengalaman nyata.',
            'daring' => 'Acara virtual dari mana saja. Cukup buka laptop atau ponsel, tanpa perlu pergi ke lokasi.',
            'hybrid' => 'Gabungan luring dan daring. Fleksibel untuk semua peserta, hadir langsung atau dari rumah.',
        ];
    @endphp
    <section class="py-16 sm:py-20 lg:py-24 bg-neutral-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Pilihan Acara</h2>
                <p class="text-sm text-neutral-muted mt-2">Pilih format acara sesuai kenyamananmu</p>
            </div>
            <div class="flex flex-col gap-5 max-w-4xl mx-auto">
                @foreach($eventTypes as $type)
                    <a href="{{ route('events.index', ['type' => $type->slug]) }}" class="group flex items-center gap-6 p-6 sm:p-8 rounded-2xl bg-white border border-neutral-border hover:border-primary/40 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        {{-- Icon --}}
                        <div class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-primary-light flex items-center justify-center text-3xl sm:text-4xl group-hover:scale-110 transition-transform duration-300">
                            @if(strtolower($type->name) === 'daring' || strtolower($type->name) === 'online') &#x1F310;
                            @elseif(strtolower($type->name) === 'luring' || strtolower($type->name) === 'offline') &#x1F3DB;&#xFE0F;
                            @else &#x1F504; @endif
                        </div>
                        {{-- Text --}}
                        <div class="flex-1 min-w-0">
                            <h3 class="text-lg sm:text-xl font-bold text-neutral-text font-poppins group-hover:text-primary transition-colors">{{ $type->name }}</h3>
                            <p class="text-sm text-neutral-muted mt-1 leading-relaxed">{{ $typeDescriptions[$type->slug] ?? 'Jelajahi semua jenis acara yang tersedia.' }}</p>
                        </div>
                        {{-- Arrow --}}
                        <div class="shrink-0 text-neutral-muted group-hover:text-primary group-hover:translate-x-1 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>



    {{-- CARA KERJA EVENTHUB — PROGRESSBAR --}}
    @php
        $steps = [
            ["title" => "Buat Akun", "desc" => "Daftar gratis dalam hitungan detik. Isi nama, email, dan password kamu. Siap dalam 30 detik."],
            ["title" => "Temukan Event", "desc" => "Jelajahi ribuan event berdasarkan tema, format, dan lokasi. Gunakan filter untuk menemukan yang paling relevan."],
            ["title" => "Daftar Event", "desc" => "Pilih event yang kamu suka dan klik Daftar. Konfirmasi akan langsung kamu terima melalui notifikasi."],
            ["title" => "Hadiri & Nikmati", "desc" => "Datang ke event dan nikmati pengalaman seru bersama peserta lainnya. Semoga hari-harimu menyenangkan!"],
        ];
    @endphp
<section class="py-16 sm:py-20 lg:py-24 bg-white"
         x-data="{
             active: 0, total: 4, playing: true, timer: null,
             start() { this.timer = setInterval(() => { if (this.playing) this.active = (this.active + 1) % this.total; }, 4000); },
             stop() { clearInterval(this.timer); },
             goTo(i) { this.active = i; this.playing = false; this.stop(); },
             next() { this.active = (this.active + 1) % this.total; this.playing = false; this.stop(); },
             prev() { this.active = (this.active - 1 + this.total) % this.total; this.playing = false; this.stop(); },
             resume() { this.playing = true; this.stop(); this.start(); }
         }"
         x-init="start()" @mouseenter="playing = false" @mouseleave="resume()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Cara Kerja EventHub</h2>
            <p class="text-sm text-neutral-muted mt-2">4 langkah mudah untuk memulai</p>
        </div>
        <div class="max-w-3xl mx-auto mb-12" data-aos="fade-up" data-aos-delay="100">
            <div class="relative flex items-center justify-between">
                <div class="absolute top-4 sm:top-5 left-0 right-0 h-1 bg-neutral-border rounded-full mx-6 sm:mx-10"></div>
                <div class="absolute top-4 sm:top-5 left-0 h-1 bg-primary rounded-full mx-6 sm:mx-10 transition-all duration-700 ease-out" :class="active === 0 ? 'w-0' : active === 1 ? 'w-1/3' : active === 2 ? 'w-2/3' : 'w-full'"></div>
                @foreach($steps as $i => $step)
                    <div class="relative z-10 flex flex-col items-center cursor-pointer group" @click="goTo({{ $i }})">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold transition-all duration-500" :class="active > {{ $i }} ? 'bg-primary text-white scale-100' : active === {{ $i }} ? 'bg-primary text-white ring-4 ring-primary/20 scale-110 shadow-lg shadow-primary/30' : 'bg-white text-neutral-muted border-2 border-neutral-border group-hover:border-primary/40'">
                            <template x-if="active > {{ $i }}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></template>
                            <template x-if="active <= {{ $i }}"><span x-text="{{ $i + 1 }}"></span></template>
                        </div>
                        <p class="mt-2 sm:mt-3 text-[10px] sm:text-sm font-semibold text-center transition-colors duration-300 whitespace-nowrap" :class="active >= {{ $i }} ? 'text-primary' : 'text-neutral-muted'">{{ $step['title'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="max-w-3xl mx-auto" data-aos="fade-up" data-aos-delay="200">
            <div class="bg-gradient-to-br from-primary/5 via-white to-secondary-light/10 rounded-2xl border border-primary/10 p-6 sm:p-8 lg:p-10 min-h-[200px] sm:min-h-[240px] flex flex-col justify-between relative">
                <div class="relative min-h-[120px] sm:min-h-[140px]">
                    @foreach($steps as $i => $step)
                        <div x-show="active === {{ $i }}" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="position:absolute;width:100%;top:0;left:0;">
                            <div class="flex items-center gap-4 mb-5">
                                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-primary text-white flex items-center justify-center shrink-0 shadow-lg shadow-primary/20"><span class="text-base sm:text-xl font-bold">{{ $i + 1 }}</span></div>
                                <h3 class="text-lg sm:text-2xl font-bold text-neutral-text font-poppins">{{ $step['title'] }}</h3>
                            </div>
                            <p class="text-neutral-muted leading-relaxed text-sm sm:text-base">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between mt-6 sm:mt-8 pt-5 sm:pt-6 border-t border-neutral-border/50">
                    <button @click="prev()" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-neutral-muted hover:text-primary rounded-xl hover:bg-primary-light transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </button>
                    <div class="flex items-center gap-2">
                        @foreach($steps as $i => $step)
                            <button @click="goTo({{ $i }})" class="h-2 rounded-full transition-all duration-300" :class="active === {{ $i }} ? 'bg-primary w-6' : 'bg-neutral-border hover:bg-primary/40 w-2'"></button>
                        @endforeach
                    </div>
                    <button @click="next()" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all duration-300">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
    {{-- EVENT TERATAS --}}
    @if($topEvents->count())
    <section class="py-16 sm:py-20 lg:py-24 bg-neutral-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Event Teratas</h2>
                <p class="text-sm text-neutral-muted mt-2">Event dengan antusiasme tertinggi</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($topEvents as $event)
                    <div class="relative" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        @if($loop->index < 3)
                            <div class="absolute -top-3 -left-3 z-10 w-10 h-10 rounded-full {{ $loop->index === 0 ? 'bg-[#FFD700] text-[#8B6914]' : ($loop->index === 1 ? 'bg-[#C0C0C0] text-[#666]' : 'bg-[#CD7F32] text-white') }} flex items-center justify-center text-sm font-bold shadow-md">{{ $loop->index + 1 }}</div>
                        @endif
                        <x-event-card :title="$event->title" :category="$event->category->name ?? 'Umum'" :date="$event->start_at ? $event->start_at->locale('id')->translatedFormat('D, d M Y') : 'TBD'" :location="$event->city->name ?? $event->location ?? 'Online'" :image="$event->banner_url" :href="route('events.show', $event->slug)" :favorites="$event->favorites_count ?? 0" :registrations="$event->registrations_count ?? 0" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10" data-aos="fade-up">
                <a href="{{ route('events.index') }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-white border border-neutral-border text-sm font-semibold text-neutral-text hover:border-primary hover:text-primary hover:shadow-md transition-all duration-300">Lihat Semua Event <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
            </div>
        </div>
    </section>
    @endif

    {{-- EVENT TERBARU --}}
    @if($latestEvents->count())
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Event Terbaru</h2>
                <p class="text-sm text-neutral-muted mt-2">Event yang baru saja dipublikasikan</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestEvents as $event)
                    <div data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <x-event-card :title="$event->title" :category="$event->category->name ?? 'Umum'" :date="$event->start_at ? $event->start_at->locale('id')->translatedFormat('D, d M Y') : 'TBD'" :location="$event->city->name ?? $event->location ?? 'Online'" :image="$event->banner_url" :href="route('events.show', $event->slug)" :favorites="$event->favorites_count ?? 0" :registrations="$event->registrations_count ?? 0" />
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-10" data-aos="fade-up">
                <a href="{{ route('events.index', ['sort' => 'newest']) }}" class="inline-flex items-center px-6 py-3 rounded-xl bg-white border border-neutral-border text-sm font-semibold text-neutral-text hover:border-primary hover:text-primary hover:shadow-md transition-all duration-300">Lihat Event Terbaru <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a>
            </div>
        </div>
    </section>
    @endif

    {{-- TESTIMONI PARALLAX --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-neutral-bg overflow-hidden"
        x-data="{ scrollPos: 0, isPaused: false, canScrollLeft: false, canScrollRight: true }"
        x-init='const c = $refs.scrollContainer; if(c) { const update = () => { canScrollLeft = c.scrollLeft > 5; canScrollRight = c.scrollLeft < c.scrollWidth - c.clientWidth - 5; }; c.addEventListener("scroll", update); update(); setInterval(() => { if (!isPaused && c) { scrollPos += 1; if (scrollPos >= c.scrollWidth - c.clientWidth) scrollPos = 0; c.scrollLeft = scrollPos; } }, 30); c.addEventListener("wheel", (e) => { if (Math.abs(e.deltaY) > Math.abs(e.deltaX)) { e.preventDefault(); c.scrollLeft += e.deltaY; } }, { passive: false }); }'
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins" data-aos="fade-up">Apa Kata Mereka?</h2>
                <p class="text-sm text-neutral-muted mt-2" data-aos="fade-up" data-aos-delay="100">Testimoni dari member EventHub</p>
            </div>
        </div>
        
        @php($testimonials = [['name' => 'Rina Sari', 'role' => 'Member Aktif', 'quote' => 'EventHub memudahkan saya menemukan workshop desain di Bandung.', 'rating' => 5, 'color' => 'bg-primary'], ['name' => 'Ahmad Fauzi', 'role' => 'Member Sejak 2025', 'quote' => 'Saya sudah 5 kali daftar event lewat EventHub. Lancar!', 'rating' => 5, 'color' => 'bg-[#635BFF]'], ['name' => 'Dewi Lestari', 'role' => 'Pecinta Workshop', 'quote' => 'Suka fitur favoritnya. Bisa simpan event menarik.', 'rating' => 4, 'color' => 'bg-[#F5A623]'], ['name' => 'Budi Santoso', 'role' => 'Member Aktif', 'quote' => 'Dashboard intuitif. Riwayat registrasi terlihat jelas.', 'rating' => 5, 'color' => 'bg-success'], ['name' => 'Maya Putri', 'role' => 'Tech Enthusiast', 'quote' => 'Event teknologi di Jakarta selalu saya temukan di EventHub.', 'rating' => 4, 'color' => 'bg-[#635BFF]'], ['name' => 'Rizki Pratama', 'role' => 'Member Sejak 2024', 'quote' => 'Proses registrasi cepat, tidak ribet. Langsung konfirmasi.', 'rating' => 5, 'color' => 'bg-primary'], ['name' => 'Sari Dewi', 'role' => 'Pencari Event', 'quote' => 'Filter pencarian sangat membantu. Cari by kota dan tema.', 'rating' => 4, 'color' => 'bg-[#F5A623]'], ['name' => 'Andi Wijaya', 'role' => 'Member & Organizer', 'quote' => 'Saya organiser sekaligus member. EventHub platform terbaik.', 'rating' => 5, 'color' => 'bg-[#635BFF]'], ['name' => 'Lestari Ningrum', 'role' => 'Member Aktif', 'quote' => 'Sering dapat info event baru lewat EventHub. Sangat update!', 'rating' => 5, 'color' => 'bg-success'], ['name' => 'Firmansyah', 'role' => 'Event Goer', 'quote' => 'Rating bintang memudahkan pilih event. Terima kasih!', 'rating' => 4, 'color' => 'bg-primary']])
        <div class="relative group">
            <button @click="isPaused=true;const c=$refs.scrollContainer;if(c)c.scrollBy({left:-420,behavior:'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/90 backdrop-blur shadow-lg border border-neutral-border/60 flex items-center justify-center text-neutral-muted hover:text-primary hover:bg-white hover:shadow-xl hover:scale-110 transition-all duration-300" :class="{'opacity-0 pointer-events-none':!canScrollLeft}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
            <button @click="isPaused=true;const c=$refs.scrollContainer;if(c)c.scrollBy({left:420,behavior:'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/90 backdrop-blur shadow-lg border border-neutral-border/60 flex items-center justify-center text-neutral-muted hover:text-primary hover:bg-white hover:shadow-xl hover:scale-110 transition-all duration-300" :class="{'opacity-0 pointer-events-none':!canScrollRight}"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
            <div x-ref="scrollContainer" @mouseenter="isPaused=true" @mouseleave="isPaused=false" @touchstart="isPaused=true" @touchend="isPaused=false" class="flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory px-6 py-4" style="scrollbar-width:none;-ms-overflow-style:none;">
                @foreach($testimonials as $idx => $t)
                <div class="flex-none w-[340px] sm:w-[380px] snap-center p-7 rounded-2xl border border-neutral-border bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $idx * 80 }}">
                    <div class="flex items-center gap-1 mb-5">@for($s=0;$s<$t['rating'];$s++)<svg class="w-5 h-5 text-secondary fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                    <p class="text-sm sm:text-base text-neutral-text leading-relaxed mb-5">&ldquo;{{ $t['quote'] }}&rdquo;</p>
                    <div class="flex items-center gap-3 pt-4 border-t border-neutral-border/60"><div class="w-11 h-11 rounded-full {{ $t['color'] }} text-white font-bold text-sm flex items-center justify-center shadow-sm">{{ strtoupper(substr($t['name'],0,2)) }}</div><div><p class="text-sm font-semibold text-neutral-text">{{ $t['name'] }}</p><p class="text-xs text-neutral-muted">{{ $t['role'] }}</p></div></div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TAWARAN CTA --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12"><h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Mulai Sekarang</h2><p class="text-base text-neutral-muted mt-3">Bergabunglah dengan ribuan pengguna EventHub</p></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <div class="rounded-2xl bg-gradient-to-br from-[#635BFF] to-[#4F46E5] p-10 sm:p-14 hover:shadow-xl transition-shadow duration-300"><div class="text-4xl mb-5">&#x1F680;</div><h3 class="text-xl font-bold text-white font-poppins mb-2">Mulai Petualanganmu</h3><p class="text-sm text-white/80 leading-relaxed mb-8">Buat akun gratis dan temukan event menarik di seluruh Indonesia.</p><a href="{{ url('/register') }}" class="inline-flex items-center px-6 py-3 bg-white text-[#635BFF] text-sm font-semibold rounded-xl hover:bg-white/90 shadow-sm transition-all hover:scale-105 active:scale-95">Daftar Sekarang</a></div>
                <div class="rounded-2xl bg-gradient-to-br from-[#FFB547] to-[#F5A623] p-10 sm:p-14 hover:shadow-xl transition-shadow duration-300"><div class="text-4xl mb-5">&#x1F3A4;</div><h3 class="text-xl font-bold text-white font-poppins mb-2">Jadi Organizer</h3><p class="text-sm text-white/80 leading-relaxed mb-8">Ajukan proposal dan mulai mengelola event sendiri di EventHub.</p><a href="{{ url('/register') }}?role=organizer" class="inline-flex items-center px-6 py-3 bg-white text-[#F5A623] text-sm font-semibold rounded-xl hover:bg-white/90 shadow-sm transition-all hover:scale-105 active:scale-95">Ajukan Proposal</a></div>
            </div>
        </div>
    </section>

    @push('styles')
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        @keyframes scroll-left { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
        .animate-scroll-left { animation: scroll-left 25s linear infinite; }
        .animate-scroll-left:hover { animation-play-state: paused; }
        @media (max-width: 640px) { #back-to-top-btn { bottom: 84px !important; } }
    </style>
    @endpush
    @push('scripts')
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>document.addEventListener('DOMContentLoaded', function () { AOS.init({ duration: 600, once: true, offset: 80 }); });</script>
    @endpush

    <!-- Back to Top Button -->
    <div id="back-to-top-btn" x-data="{ show: false }" x-init="window.addEventListener('scroll', () => { show = window.scrollY > 600 })" class="fixed bottom-6 right-6 z-50" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4">
        <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' })" class="w-12 h-12 rounded-full bg-primary text-white shadow-lg hover:bg-primary-hover hover:shadow-xl transition-all flex items-center justify-center" title="Kembali ke atas"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg></button>
    </div>

</x-public-layout>
