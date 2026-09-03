@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Edit Event', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => '/organizer/events'], ['label' => 'Edit Event']]])

@section('title', 'Edit Event')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0 max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-neutral-text font-poppins">Edit Event</h2>
                    @php($statusVariant = match($event->status) {
                        'published' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'error',
                        default => 'neutral'
                    })
                    <x-badge variant="{{ $statusVariant }}">{{ ucfirst($event->status) }}</x-badge>
                </div>

                @if($event->status === 'rejected' && $event->rejection_reason)
                    <div class="mb-6 p-4 rounded-xl bg-error-light border border-error/20 text-error text-sm">
                        <span class="font-semibold block mb-1">Rejection Reason:</span>
                        {{ $event->rejection_reason }}
                    </div>
                @endif

                @if(session('success'))
                    <x-alert type="success" dismissible="true" class="mb-6">
                        {{ session('success') }}
                    </x-alert>
                @endif

                <form class="space-y-6" action="{{ route('organizer.events.update', $event) }}" method="POST" x-data="{ jenis: '{{ old('event_type_id', $event->event_type_id ?? '') }}' }">
                    @csrf
                    @method('PATCH')

                    <!-- Event Title -->
                    <x-input 
                        label="Event Title" 
                        name="title" 
                        placeholder="e.g. Tech Conference 2026" 
                        hint="A clear and compelling title for your event"
                        value="{{ old('title', $event->title) }}"
                        :error="$errors->first('title')"
                    />

                    <!-- Slug -->
                    <x-input 
                        label="Slug" 
                        name="slug" 
                        placeholder="tech-conference-2026" 
                        hint="URL-friendly identifier (leave empty to auto-generate)"
                        value="{{ old('slug', $event->slug) }}"
                    />

                    <!-- Theme/Category -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Theme <span class="text-error">*</span>
                        </label>
                        <select name="category_id" required class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('category_id') ? 'border-error' : '' }}">
                            <option value="">Select a theme</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">Description</label>
                        <textarea name="description" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 min-h-[120px] {{ $errors->has('description') ? 'border-error' : '' }}">{{ old('description', $event->description) }}</textarea>
                        @error('description') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Jenis Acara -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Jenis Acara <span class="text-error">*</span>
                        </label>
                        <select name="event_type_id" x-model="jenis" required class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('event_type_id') ? 'border-error' : '' }}">
                            <option value="">Select event type</option>
                            @foreach($eventTypes as $type)
                                <option value="{{ $type->id }}" {{ old('event_type_id', $event->event_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('event_type_id') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Format Acara -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">
                            Format Acara <span class="text-xs text-neutral-muted font-normal">(optional)</span>
                        </label>
                        <select name="event_format_id" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">
                            <option value="">Select format (optional)</option>
                            @foreach($formats as $format)
                                <option value="{{ $format->id }}" {{ old('event_format_id', $event->event_format_id) == $format->id ? 'selected' : '' }}>{{ $format->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date & Time Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">
                                Start Date & Time <span class="text-error">*</span>
                            </label>
                            <input type="datetime-local" name="start_at" value="{{ old('start_at', $event->start_at ? $event->start_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('start_at') ? 'border-error' : '' }}" />
                            @error('start_at') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">
                                End Date & Time <span class="text-error">*</span>
                            </label>
                            <input type="datetime-local" name="end_at" value="{{ old('end_at', $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150 {{ $errors->has('end_at') ? 'border-error' : '' }}" />
                            @error('end_at') <p class="text-xs text-error font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Timezone -->
                    <div class="space-y-1.5 w-full">
                        <label class="block text-sm font-medium text-neutral-text">Timezone</label>
                        <select name="timezone" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">
                            <option value="Asia/Jakarta" {{ old('timezone', $event->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB, UTC+7)</option>
                            <option value="Asia/Makassar" {{ old('timezone', $event->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA, UTC+8)</option>
                            <option value="Asia/Jayapura" {{ old('timezone', $event->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT, UTC+9)</option>
                        </select>
                    </div>

                    <!-- Location Section -->
                    <div class="pt-4 border-t border-neutral-border">
                        <h3 class="text-base font-semibold text-neutral-text font-poppins mb-4">Location Details</h3>
                        
                        <!-- Kota -->
                        <div class="space-y-1.5 mb-6" x-show="jenis !== ''">
                            <label class="block text-sm font-medium text-neutral-text">Kota</label>
                            <select name="city_id" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">
                                <option value="">Pilih kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $event->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Venue/Location -->
                        <div class="space-y-1.5 mb-6" x-show="jenis !== ''">
                            <label class="block text-sm font-medium text-neutral-text">Venue / Lokasi</label>
                            <input type="text" name="location" value="{{ old('location', $event->location) }}" placeholder="e.g. Grand Ballroom, Hotel Mulia" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150" />
                        </div>

                        <!-- Online URL -->
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Online URL</label>
                            <input type="url" name="online_url" value="{{ old('online_url', $event->online_url) }}" placeholder="e.g. https://zoom.us/j/123456789" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150" />
                        </div>
                    </div>

                    <!-- Capacity & Registration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Capacity</label>
                            <input type="number" name="capacity" value="{{ old('capacity', $event->capacity) }}" placeholder="e.g. 100" min="1" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Registration Deadline</label>
                            <input type="datetime-local" name="registration_deadline" value="{{ old('registration_deadline', $event->registration_deadline ? $event->registration_deadline->format('Y-m-d\TH:i') : '') }}" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150" />
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="pt-4 border-t border-neutral-border space-y-4" x-data="{ payment: '{{ old('payment_method', $event->payment_method ?? 'free') }}' }">
                        <h3 class="text-base font-semibold text-neutral-text font-poppins">Metode Pembayaran</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'free' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="free" x-model="payment" class="text-primary focus:ring-primary">
                                <div><p class="text-sm font-semibold text-neutral-text">Gratis</p><p class="text-xs text-neutral-muted">Tidak ada biaya</p></div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'upfront' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="upfront" x-model="payment" class="text-primary focus:ring-primary">
                                <div><p class="text-sm font-semibold text-neutral-text">Bayar di Muka</p><p class="text-xs text-neutral-muted">Transfer sebelum event</p></div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all" :class="payment === 'onsite' ? 'border-primary bg-primary-light/30' : 'border-neutral-border hover:border-primary/40'">
                                <input type="radio" name="payment_method" value="onsite" x-model="payment" class="text-primary focus:ring-primary">
                                <div><p class="text-sm font-semibold text-neutral-text">Bayar di Tempat</p><p class="text-xs text-neutral-muted">Bayar saat hari H</p></div>
                            </label>
                        </div>
                        <div x-show="payment === 'upfront'" x-transition class="space-y-1.5">
                            <label class="block text-sm font-medium text-neutral-text">Info Pembayaran</label>
                            <textarea name="payment_info" rows="3" placeholder="Informasi rekening atau metode transfer" class="w-full rounded-xl border border-neutral-border bg-white p-3.5 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all duration-150">{{ old('payment_info', $event->payment_info) }}</textarea>
                        </div>
                    </div>

                                        <!-- Action Buttons -->
                    <div class="pt-6 border-t border-neutral-border flex items-center justify-end gap-3">
                        <a href="{{ route('organizer.events.index') }}" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Kembali</a>
                        @if($event->status === 'published')
                            <span class="text-xs text-info bg-info-light px-3 py-1.5 rounded-lg">
                                ℹ️ Edit published: perubahan substantif akan dikembalikan ke pending
                            </span>
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover shadow-sm transition-all">
                                Simpan Perubahan
                            </button>
                        @else
                            <button type="submit" class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover shadow-sm transition-all">
                                Simpan
                            </button>
                            @if(in_array($event->status, ['draft', 'rejected']))
                                <button type="submit" name="submit_type" value="submit" class="px-5 py-2.5 bg-success text-white text-sm font-semibold rounded-xl hover:bg-success shadow-sm transition-all">
                                    Kirim untuk Review
                                </button>
                            @endif
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
