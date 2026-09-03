@extends('layouts.organizer', ['activeNav' => 'create', 'pageTitle' => 'Buat Event', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => '/organizer/events'], ['label' => 'Buat Event']]])

@section('title', 'Buat Event')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <h2 class="text-xl font-bold text-neutral-text font-poppins mb-6">Buat Event Baru</h2>

                <form class="space-y-6" action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" x-data="{ jenis: '{{ old('event_type_id') }}' }">
                    @csrf

                    <!-- Judul Event -->
                    <x-input 
                        label="Judul Event" 
                        name="title" 
                        placeholder="contoh: Konferensi Teknologi 2026" 
                        hint="Judul yang jelas dan menarik untuk eventmu"
                        value="{{ old('title') }}"
                        :error="$errors->first('title')"
                    />

                    <!-- Slug -->
                    <x-input 
                        label="Slug" 
                        name="slug" 
                        placeholder="tech-conference-2026" 
                        hint="Identifikasi URL (kosongkan untuk auto-generate)"
                        value="{{ old('slug') }}"
                    />

                    <!-- Theme/Category -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Theme <span class="text-error">*</span>
                        </label>
                        <select 
                            name="category_id"
                            required
                            class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('category_id') ? 'border-error focus:border-error focus:ring-error/20' : '' }}"
                        >
                            <option value="">Pilih tema</option>
                            @forelse($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @empty
                                <option value="" disabled>Belum ada tema.</option>
                            @endforelse
                        </select>
                        @error('category_id')
                            <p class="text-xs text-error font-medium flex items-center gap-1 mt-1">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Description
                        </label>
                        <textarea 
                            name="description"
                            class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 min-h-[120px]"
                            placeholder="Deskripsikan eventmu, apa yang peserta dapatkan, dan mengapa mereka harus ikut..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-error font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Banner Upload (Preview) -->
                    <div class="space-y-1.5 w-full" x-data="{ preview: null }">
                        <label class="block text-sm font-medium text-neutral-text">Banner Event</label>
                        <div x-show="!preview" @click="$refs.bannerInput.click()" class="border-2 border-dashed border-neutral-border rounded-xl p-8 text-center bg-neutral-bg/30 hover:border-primary/40 transition-colors cursor-pointer">
                            <svg class="w-12 h-12 text-neutral-muted/50 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="text-sm text-neutral-muted font-medium mb-1">Klik untuk upload banner</p>
                            <p class="text-xs text-neutral-muted">Rekomendasi: 1200x630px, maks 2MB</p>
                        </div>
                        <div x-show="preview" class="relative">
                            <img :src="preview" class="w-full h-48 object-cover rounded-xl mb-2">
                            <button type="button" @click="preview = null; $refs.bannerInput.value = ''" class="absolute top-2 right-2 p-2 bg-error text-white rounded-lg hover:bg-error-hover transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <input type="file" name="banner" accept="image/*" class="hidden" x-ref="bannerInput" @change="const f = $refs.bannerInput.files[0]; if(f) { preview = URL.createObjectURL(f); }">
                    </div>

                    <!-- Jenis Acara (Event Type) -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Jenis Acara <span class="text-error">*</span>
                        </label>
                        <select 
                            name="event_type_id"
                            x-model="jenis"
                            required
                            class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('event_type_id') ? 'border-error' : '' }}"
                        >
                            <option value="">Pilih jenis acara (Daring/Luring/Hybrid)</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type->id }}" {{ old('event_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('event_type_id')
                            <p class="text-xs text-error font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Format Acara (Optional) -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Format Acara <span class="text-xs text-neutral-muted font-normal">(optional)</span>
                        </label>
                        <select 
                            name="event_format_id"
                            class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                        >
                            <option value="">Pilih format (opsional)</option>
                            @foreach($formats as $format)
                                <option value="{{ $format->id }}" {{ old('event_format_id') == $format->id ? 'selected' : '' }}>{{ $format->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date & Time Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">
                                Tanggal & Waktu Mulai <span class="text-error">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="start_at"
                                value="{{ old('start_at') }}"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('start_at') ? 'border-error' : '' }}"
                            />
                            @error('start_at') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">
                                Tanggal & Waktu Selesai <span class="text-error">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="end_at"
                                value="{{ old('end_at') }}"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('end_at') ? 'border-error' : '' }}"
                            />
                            @error('end_at') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Timezone -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">Zona Waktu</label>
                        <select name="timezone" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">
                            <option value="Asia/Jakarta" {{ old('timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB, UTC+7)</option>
                            <option value="Asia/Makassar" {{ old('timezone') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA, UTC+8)</option>
                            <option value="Asia/Jayapura" {{ old('timezone') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT, UTC+9)</option>
                        </select>
                    </div>

                    <!-- Location Section -->
                    <div class="pt-4 border-t border-neutral-border">
                        <h3 class="text-base font-semibold text-neutral-text font-poppins mb-4">Detail Lokasi</h3>
                        
                        <!-- Kota -->
                        <div class="space-y-1.5 mb-6" x-show="jenis !== ''">
                            <label class="block text-sm font-medium text-neutral-text">Kota</label>
                            <select name="city_id" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">
                                <option value="">Pilih kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Venue/Location -->
                        <div class="space-y-1.5 mb-6" x-show="jenis !== ''">
                            <label class="block text-sm font-medium text-neutral-text">Venue / Lokasi</label>
                            <input 
                                type="text" 
                                name="location"
                                value="{{ old('location') }}"
                                placeholder="e.g. Grand Ballroom, Hotel Mulia"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                            />
                            <p class="text-xs text-neutral-muted">Wajib untuk event Luring dan Hybrid</p>
                        </div>

                        <!-- Online URL -->
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Online URL</label>
                            <input 
                                type="url" 
                                name="online_url"
                                value="{{ old('online_url') }}"
                                placeholder="e.g. https://zoom.us/j/123456789"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                            />
                            <p class="text-xs text-neutral-muted">Wajib untuk event Daring dan Hybrid</p>
                        </div>
                    </div>

                    <!-- Capacity & Registration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Kapasitas</label>
                            <input 
                                type="number" 
                                name="capacity"
                                placeholder="contoh: 100"
                                min="1"
                                value="{{ old('capacity') }}"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                            />
                            <p class="text-xs text-neutral-muted">Jumlah maksimal peserta</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Batas Registrasi</label>
                            <input 
                                type="datetime-local" 
                                name="registration_deadline"
                                value="{{ old('registration_deadline') }}"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                            />
                            <p class="text-xs text-neutral-muted">Batas akhir pendaftaran</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="pt-4 border-t border-neutral-border space-y-4" x-data="{ payment: '{{ old('payment_method', 'free') }}' }">
                        <h3 class="text-base font-semibold text-neutral-text font-poppins">Metode Pembayaran</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'free' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="free" x-model="payment" class="text-primary focus:ring-primary">
                                <div>
                                    <p class="text-sm font-semibold text-neutral-text">Gratis</p>
                                    <p class="text-xs text-neutral-muted">Tidak ada biaya</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'upfront' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="upfront" x-model="payment" class="text-primary focus:ring-primary">
                                <div>
                                    <p class="text-sm font-semibold text-neutral-text">Bayar di Muka</p>
                                    <p class="text-xs text-neutral-muted">Transfer sebelum event</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'onsite' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="onsite" x-model="payment" class="text-primary focus:ring-primary">
                                <div>
                                    <p class="text-sm font-semibold text-neutral-text">Bayar di Tempat</p>
                                    <p class="text-xs text-neutral-muted">Bayar saat hari H</p>
                                </div>
                            </label>
                        </div>

                        <div x-show="payment === 'upfront'" x-transition class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Info Pembayaran</label>
                            <textarea 
                                name="payment_info"
                                rows="3"
                                placeholder="Contoh:&#10;BCA: 1234567890 a.n. PT EventHub&#10;Mandiri: 9876543210 a.n. PT EventHub"
                                class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150"
                            >{{ old('payment_info') }}</textarea>
                            <p class="text-xs text-neutral-muted">Informasi rekening atau metode transfer untuk peserta</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-neutral-border flex items-center justify-end gap-3">
                        <a href="{{ route('organizer.events.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover shadow-sm transition-all">
                            Simpan Draft
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
