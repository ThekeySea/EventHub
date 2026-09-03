<x-public-layout :title="$event->title . ' — EventHub'">

    <!-- Breadcrumb -->
    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <nav class="flex items-center gap-2 text-xs text-neutral-muted">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a>
                <span>/</span>
                <a href="{{ route('events.index') }}" class="hover:text-primary transition-colors">Event</a>
                <span>/</span>
                <span class="text-neutral-text font-medium truncate">{{ $event->title }}</span>
            </nav>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <x-alert type="error" dismissible="true">{{ $errors->first() }}</x-alert>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content (2/3 width) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Event Banner -->
                @if($event->banner)
                    <div class="rounded-2xl overflow-hidden border border-neutral-border shadow-sm">
                        <img src="{{ $event->banner_url }}" alt="{{ $event->title }}" class="w-full h-64 sm:h-80 object-cover">
                    </div>
                @else
                    <div class="rounded-2xl overflow-hidden border border-neutral-border shadow-sm bg-gradient-to-br from-primary/10 via-primary-light to-secondary-light h-64 sm:h-80 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto text-primary/30 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-primary/50 font-medium">{{ $event->title }}</p>
                        </div>
                    </div>
                @endif

                <!-- Title + Meta -->
                <div>
                    <div class="flex items-start gap-3 mb-3">
                        <h1 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins flex-1">{{ $event->title }}</h1>
                        @php($statusColors = ['published' => 'success'])
                        <x-badge variant="success">Published</x-badge>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-neutral-muted">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $event->organizer->name ?? 'Tidak Diketahui' }}
                        </span>
                        @if($event->category)
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                {{ $event->category->name }}
                            </span>
                        @endif
                        @if($event->eventType)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-info-light text-info">
                                {{ $event->eventType->name }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-neutral-text font-poppins mb-4">Deskripsi Event</h2>
                    <div class="prose prose-sm max-w-none text-neutral-text">
                        {!! nl2br(e($event->description ?? 'Tidak ada deskripsi.')) !!}
                    </div>
                </div>

                <!-- Event Details Grid -->
                <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-neutral-text font-poppins mb-4">Detail Event</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Date & Time -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider">Tanggal & Waktu</p>
                                <p class="text-sm text-neutral-text mt-0.5">
                                    {{ $event->start_at ? $event->start_at->locale('id')->translatedFormat('l, d M Y') : '—' }}
                                </p>
                                <p class="text-xs text-neutral-muted">
                                    {{ $event->start_at ? $event->start_at->format('H:i') : '—' }} — {{ $event->end_at ? $event->end_at->format('H:i') : '—' }} {{ $event->timezone }}
                                </p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-secondary-light text-secondary flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider">Lokasi</p>
                                @if($event->eventType && $event->eventType->slug === 'daring')
                                    <p class="text-sm text-neutral-text mt-0.5">Online</p>
                                    @if($event->online_url)
                                        <a href="{{ $event->online_url }}" target="_blank" class="text-xs text-primary hover:text-primary-hover mt-0.5 inline-block">Buka Link Event →</a>
                                    @endif
                                @else
                                    <p class="text-sm text-neutral-text mt-0.5">{{ $event->city->name ?? '' }}{{ $event->location ? ', ' . $event->location : '' }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Format -->
                        @if($event->eventFormat)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-info-light text-info flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider">Format Acara</p>
                                    <p class="text-sm text-neutral-text mt-0.5">{{ $event->eventFormat->name }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Capacity -->
                        @if($event->capacity)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center shrink-0">&#x1F465;</div>
                                <div>
                                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider">Kapasitas</p>
                                    <p class="text-sm text-neutral-text mt-0.5">{{ $slotsRemaining !== null ? $slotsRemaining . ' slot tersisa dari ' . $event->capacity : 'Tidak terbatas' }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Registration Deadline -->
                        @if($event->registration_deadline)
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-warning-light text-warning flex items-center justify-center shrink-0">&#x23F0;</div>
                                <div>
                                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider">Batas Registrasi</p>
                                    <p class="text-sm text-neutral-text mt-0.5">{{ $event->registration_deadline->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm sticky top-24 space-y-4">
                    <!-- Payment Info -->
                    @if($event->payment_method !== 'free')
                    <div class="p-4 rounded-xl {{ $event->payment_method === 'upfront' ? 'bg-warning-light/30 border border-warning/20' : 'bg-info-light/30 border border-info/20' }}">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-lg">{{ $event->payment_method === 'upfront' ? '&#x1F4B3;' : '&#x1F4BC;' }}</span>
                            <p class="text-sm font-semibold text-neutral-text">{{ $event->payment_method_label }}</p>
                        </div>
                        @if($event->payment_method === 'upfront' && $event->payment_info)
                            <div class="mt-2 p-3 rounded-lg bg-white/60">
                                <p class="text-xs font-semibold text-neutral-muted mb-1">Info Pembayaran:</p>
                                <p class="text-xs text-neutral-text whitespace-pre-line">{{ $event->payment_info }}</p>
                            </div>
                            <p class="text-[10px] text-warning mt-2 font-medium">* Pembayaran harus dikonfirmasi oleh organizer sebelum registrasi aktif.</p>
                        @endif
                        @if($event->payment_method === 'onsite')
                            <p class="text-[10px] text-info mt-1 font-medium">* Pembayaran dilakukan di tempat saat hari pelaksanaan.</p>
                        @endif
                    </div>
                    @endif

                    @auth
                        @if($canRegister)
                            <form action="{{ route('events.register', $event) }}" method="POST">@csrf
                                <button type="submit" class="w-full py-3 bg-primary text-white font-semibold rounded-xl hover:bg-primary-hover transition-colors shadow-sm">Daftar Sekarang</button>
                            </form>
                        @elseif($myRegistration)
                            <div class="w-full py-3 bg-success-light text-success font-semibold rounded-xl text-center border border-success/20">Sudah Terdaftar</div>
                            <form action="{{ route('member.registrations.destroy', $myRegistration) }}" method="POST" onsubmit="return confirm('Yakin?')">@csrf @method('DELETE')
                                <button type="submit" class="w-full py-2 text-sm font-semibold text-error border border-error/20 rounded-xl hover:bg-error-light transition-colors">Batalkan Registrasi</button>
                            </form>
                        @else
                            <div class="w-full py-3 bg-neutral-bg text-neutral-muted font-semibold rounded-xl text-center border border-neutral-border">
                                @if($slotsRemaining !== null && $slotsRemaining <= 0) Event Penuh @elseif($event->end_at->isPast()) Event Sudah Berakhir @else Registrasi Ditutup @endif
                            </div>
                        @endif
                    @else
                        <a href="{{ url('/login') }}" class="block w-full py-3 bg-primary text-white font-semibold rounded-xl text-center hover:bg-primary-hover transition-colors shadow-sm">Login untuk Daftar</a>
                    @endauth

                    @auth
                        @if($isFavorited)
                            <form action="{{ route('events.unfavorite', $event) }}" method="POST">@csrf @method('DELETE')
                                <button type="submit" class="w-full py-2.5 text-sm font-semibold text-error border border-error/20 rounded-xl hover:bg-error-light transition-colors">&#x2764; Hapus dari Favorit</button>
                            </form>
                        @else
                            <form action="{{ route('events.favorite', $event) }}" method="POST">@csrf
                                <button type="submit" class="w-full py-2.5 text-sm font-semibold text-primary border border-primary/20 rounded-xl hover:bg-primary-light transition-colors">&#x2661; Tambah ke Favorit</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ url('/login') }}" class="block w-full py-2.5 text-sm font-semibold text-primary border border-primary/20 rounded-xl text-center hover:bg-primary-light transition-colors">Login untuk Favorit</a>
                    @endauth

                    <div class="pt-4 border-t border-neutral-border">
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-2">Diselenggarakan oleh</p>
                        <p class="text-sm font-bold text-neutral-text">{{ $event->organizer->name ?? 'Unknown' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

        {{-- Report Event Form --}}
        @auth
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8" x-data="{ showReport: false }">
                <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-neutral-text">Ada masalah dengan event ini?</h3>
                            <p class="text-xs text-neutral-muted mt-0.5">Laporkan jika event ini melanggar kebijakan.</p>
                        </div>
                        <button type="button" @click="showReport = !showReport" class="px-4 py-2 text-xs font-semibold text-error border border-error/20 rounded-xl hover:bg-error-light transition-colors">
                            Laporkan Event
                        </button>
                    </div>
                    <div x-show="showReport" x-cloak x-transition class="mt-4 pt-4 border-t border-neutral-border">
                        @php($existingReport = \App\Models\EventReport::where('event_id', $event->id)->where('user_id', auth()->id())->first())
                        @if($existingReport)
                            <p class="text-sm text-neutral-muted">Anda sudah melaporkan event ini ({{ ucfirst($existingReport->status) }}).</p>
                        @else
                            <form action="{{ route('events.report', $event) }}" method="POST" class="space-y-3">
                                @csrf
                                <div>
                                    <label class="block text-xs font-semibold text-neutral-text mb-1">Alasan Laporan <span class="text-error">*</span></label>
                                    <select name="reason" required class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none">
                                        <option value="">Pilih alasan</option>
                                        <option value="spam">Spam</option>
                                        <option value="inappropriate">Tidak Pantas</option>
                                        <option value="scam">Penipuan</option>
                                        <option value="misleading">Menyesatkan</option>
                                        <option value="other">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-neutral-text mb-1">Deskripsi (opsional)</label>
                                    <textarea name="description" rows="3" placeholder="Jelaskan masalah yang Anda temukan..." class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none"></textarea>
                                </div>
                                <div class="flex gap-2 justify-end">
                                    <button type="button" @click="showReport = false" class="px-3 py-1.5 text-xs font-semibold text-neutral-text rounded-lg hover:bg-neutral-bg transition-colors">Batal</button>
                                    <button type="submit" class="px-4 py-1.5 bg-error text-white text-xs font-semibold rounded-lg hover:opacity-90 transition-colors">Kirim Laporan</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endauth
</x-public-layout>
