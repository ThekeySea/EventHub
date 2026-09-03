@extends('layouts.member')
@php($activeNav = 'dashboard')
@php($pageTitle = 'Dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="bg-white border-b border-neutral-border"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
<h1 class="text-2xl sm:text-3xl font-bold font-poppins text-neutral-text">Halo, {{ auth()->user()->name }} &#x1F44B;</h1>
<p class="text-sm text-neutral-muted mt-1">Selamat datang di dashboard kamu.</p>
</div></div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

<!-- Profile Summary -->
<div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
<div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
<div class="w-16 h-16 rounded-2xl bg-primary text-white font-bold text-xl flex items-center justify-center shadow-md shrink-0">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
<div class="flex-1 text-center sm:text-left">
<h2 class="text-lg font-bold text-neutral-text font-poppins">{{ auth()->user()->name }}</h2>
<p class="text-sm text-neutral-muted">{{ auth()->user()->email }}</p>
<div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2"><x-badge variant="primary" size="sm">{{ ucfirst(auth()->user()->role) }}</x-badge></div>
</div>
<a href="{{ route("member.profile") }}" class="px-4 py-2 text-sm font-semibold text-primary border border-primary/20 rounded-xl hover:bg-primary-light transition-colors shrink-0">Edit Profil</a>
</div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
<div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
<div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalRegistrations }}</p><p class="text-xs text-neutral-muted">Registrasi Aktif</p></div>
</div>
<div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-secondary-light text-warning flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg></div>
<div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalFavorites }}</p><p class="text-xs text-neutral-muted">Favorit</p></div>
</div>
<div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
<div class="w-12 h-12 rounded-xl bg-success-light text-success flex items-center justify-center shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
<div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalAttended }}</p><p class="text-xs text-neutral-muted">Event Diikuti</p></div>
</div>
</div>

<!-- Quick Actions -->
<div class="bg-gradient-to-r from-primary/10 via-primary-light to-secondary-light rounded-2xl border border-neutral-border p-6 shadow-sm">
<h2 class="text-lg font-bold text-neutral-text font-poppins mb-4">Aksi Cepat</h2>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
<a href="{{ route("events.index") }}" class="bg-white rounded-xl border border-neutral-border p-4 text-center hover:shadow-md hover:border-primary/40 transition-all"><p class="text-xs font-semibold text-neutral-text">&#x1F50D; Cari Event</p></a>
<a href="{{ route("member.registrations") }}" class="bg-white rounded-xl border border-neutral-border p-4 text-center hover:shadow-md hover:border-primary/40 transition-all"><p class="text-xs font-semibold text-neutral-text">&#x1F4CB; Registrasi Saya</p></a>
<a href="{{ route("member.favorites") }}" class="bg-white rounded-xl border border-neutral-border p-4 text-center hover:shadow-md hover:border-primary/40 transition-all"><p class="text-xs font-semibold text-neutral-text">&#x2764;&#xFE0F; Favorit Saya</p></a>
<a href="{{ route("member.profile") }}" class="bg-white rounded-xl border border-neutral-border p-4 text-center hover:shadow-md hover:border-primary/40 transition-all"><p class="text-xs font-semibold text-neutral-text">&#x1F464; Profil Saya</p></a>
</div>
</div>

</div>
        <!-- Upcoming Events -->
        <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-neutral-text font-poppins">Event Mendatang</h2>
                <a href="{{ route('member.registrations') }}" class="text-xs font-semibold text-primary hover:text-primary-hover">Lihat Semua &#8594;</a>
            </div>
            @if($upcomingRegistrations->count())
                <div class="space-y-3">
                    @foreach($upcomingRegistrations as $reg)
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-neutral-bg/50 border border-neutral-border/60 hover:bg-neutral-bg transition-colors">
                            <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center shrink-0">&#x1F4C5;</div>
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('events.show', $reg->event->slug) }}" class="text-sm font-bold text-neutral-text hover:text-primary transition-colors truncate block">{{ $reg->event->title }}</a>
                                <p class="text-xs text-neutral-muted mt-0.5">{{ $reg->event->start_at ? $reg->event->start_at->locale('id')->translatedFormat('d M Y, H:i') : '---' }}</p>
                            </div>
                            <x-badge variant="success" size="sm">Registered</x-badge>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-sm text-neutral-muted mb-3">Belum ada event mendatang.</p>
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-4 py-2 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-hover transition-colors">Cari Event</a>
                </div>
            @endif
        </div>
        <!-- Two Column: Favorites + History -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Recent Favorites -->
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-neutral-text font-poppins">Favorit Terbaru</h2>
                    <a href="{{ route('member.favorites') }}" class="text-xs font-semibold text-primary hover:text-primary-hover">Lihat Semua &#8594;</a>
                </div>
                @if($recentFavorites->count())
                    <div class="space-y-3">
                        @foreach($recentFavorites as $fav)
                            <a href="{{ route('events.show', $fav->event->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-bg/50 transition-colors group">
                                <div class="w-10 h-10 rounded-xl bg-secondary-light text-warning flex items-center justify-center shrink-0">&#x2764;</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-neutral-text truncate group-hover:text-primary transition-colors">{{ $fav->event->title }}</p>
                                    <p class="text-xs text-neutral-muted">{{ $fav->event->category->name ?? '---' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8"><p class="text-sm text-neutral-muted">Belum ada favorit.</p></div>
                @endif
            </div>

            <!-- Event History -->
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-neutral-text font-poppins">Riwayat Event</h2>
                </div>
                @if($pastRegistrations->count())
                    <div class="space-y-3">
                        @foreach($pastRegistrations as $reg)
                            <div class="flex items-center gap-3 p-3 rounded-xl bg-neutral-bg/30">
                                <div class="w-10 h-10 rounded-xl bg-success-light text-success flex items-center justify-center shrink-0">&#x2714;</div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-neutral-text truncate">{{ $reg->event->title }}</p>
                                    <p class="text-xs text-neutral-muted">{{ $reg->event->start_at ? $reg->event->start_at->locale('id')->translatedFormat('d M Y') : '---' }}</p>
                                </div>
                                <x-badge variant="{{ $reg->status === 'attended' ? 'success' : 'error' }}" size="sm">{{ ucfirst($reg->status) }}</x-badge>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8"><p class="text-sm text-neutral-muted">Belum ada riwayat event.</p></div>
                @endif
            </div>
        </div>
@endsection