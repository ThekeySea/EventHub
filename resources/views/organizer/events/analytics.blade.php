@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Analytics Event', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => route('organizer.events.index')], ['label' => $event->title, 'url' => route('organizer.events.show', $event)], ['label' => 'Analytics']]])

@section('title', 'Analytics — ' . $event->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-neutral-text font-poppins">Analytics Event</h2>
            <p class="text-sm text-neutral-muted mt-1">{{ $event->title }}</p>
        </div>
        <a href="{{ route('organizer.events.show', $event) }}" class="px-4 py-2 text-sm font-semibold text-neutral-text border border-neutral-border rounded-xl hover:bg-neutral-bg transition-colors">← Kembali</a>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-primary font-poppins">{{ $totalRegistered }}</p>
            <p class="text-xs text-neutral-muted mt-1">Terdaftar</p>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-info font-poppins">{{ $totalPendingPayment }}</p>
            <p class="text-xs text-neutral-muted mt-1">Menunggu Bayar</p>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-success font-poppins">{{ $totalAttended }}</p>
            <p class="text-xs text-neutral-muted mt-1">Hadir</p>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-error font-poppins">{{ $totalNoShow }}</p>
            <p class="text-xs text-neutral-muted mt-1">No-Show</p>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-neutral-muted font-poppins">{{ $totalCancelled }}</p>
            <p class="text-xs text-neutral-muted mt-1">Dibatalkan</p>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-4 shadow-sm text-center">
            <p class="text-2xl font-bold text-warning font-poppins">{{ $totalWaitlisted }}</p>
            <p class="text-xs text-neutral-muted mt-1">Daftar Tunggu</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Capacity Bar -->
        <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Kapasitas</h3>
            @if($capacity)
                <div class="mb-3">
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-neutral-text font-medium">{{ $totalRegistered }} / {{ $capacity }}</span>
                        <span class="text-primary font-semibold">{{ $capacityUsed }}%</span>
                    </div>
                    <div class="w-full h-4 bg-neutral-border rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: {{ min($capacityUsed, 100) }}%"></div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-3 text-center text-xs">
                    <div class="p-2 bg-success-light rounded-lg">
                        <p class="font-bold text-success">{{ $totalRegistered }}</p>
                        <p class="text-neutral-muted">Aktif</p>
                    </div>
                    <div class="p-2 bg-warning-light rounded-lg">
                        <p class="font-bold text-warning">{{ $totalWaitlisted }}</p>
                        <p class="text-neutral-muted">Tunggu</p>
                    </div>
                    <div class="p-2 bg-neutral-bg rounded-lg">
                        <p class="font-bold text-neutral-text">{{ $capacity - $totalRegistered }}</p>
                        <p class="text-neutral-muted">Sisa</p>
                    </div>
                </div>
            @else
                <p class="text-sm text-neutral-muted">Kapasitas tidak terbatas.</p>
            @endif
        </div>

        <!-- Check-in Rate -->
        <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Tingkat Kehadiran</h3>
            @php($checkInRate = $totalRegistered > 0 ? round(($totalAttended / $totalRegistered) * 100) : 0)
            @php($noShowRate = $totalRegistered > 0 ? round(($totalNoShow / $totalRegistered) * 100) : 0)
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-neutral-text">Hadir</span>
                        <span class="font-semibold text-success">{{ $checkInRate }}%</span>
                    </div>
                    <div class="w-full h-3 bg-neutral-border rounded-full overflow-hidden">
                        <div class="h-full bg-success rounded-full" style="width: {{ $checkInRate }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-neutral-text">No-Show</span>
                        <span class="font-semibold text-error">{{ $noShowRate }}%</span>
                    </div>
                    <div class="w-full h-3 bg-neutral-border rounded-full overflow-hidden">
                        <div class="h-full bg-error rounded-full" style="width: {{ $noShowRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Registration Trend -->
    <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
        <h3 class="text-lg font-bold text-neutral-text font-poppins mb-6">Tren Registrasi</h3>
        <div class="flex items-end gap-1 h-64">
            @foreach($dailyRegs as $day)
                <div class="flex-1 flex flex-col items-center justify-end h-full group relative"
                     x-data="{ open: false }"
                     @mouseenter="open = true" @mouseleave="open = false"
                     @click="open = !open">
                    <div class="w-full bg-primary rounded-t transition-all duration-300" style="height: {{ $day['count'] > 0 ? max(($day['count'] / $maxDaily) * 100, 10) : 2 }}%"></div>
                    <span class="text-[9px] text-neutral-muted mt-1 whitespace-nowrap">{{ $day['date'] }}</span>
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-primary text-white text-[10px] px-2.5 py-1 rounded-lg shadow-md font-medium whitespace-nowrap transition-opacity duration-200 opacity-0 z-10"
                         :class="open ? 'opacity-100' : 'opacity-0 pointer-events-none'">
                        {{ $day['count'] }} registrasi
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Payment Method -->
    <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
        <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Metode Pembayaran</h3>
        <div class="flex items-center gap-4">
            @if($event->payment_method === 'upfront')
                <div class="w-12 h-12 rounded-xl bg-warning-light text-warning flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
            @elseif($event->payment_method === 'onsite')
                <div class="w-12 h-12 rounded-xl bg-info-light text-info flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            @else
                <div class="w-12 h-12 rounded-xl bg-success-light text-success flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            @endif
            <div>
                <p class="text-lg font-bold text-neutral-text">{{ $paymentLabel }}</p>
                <p class="text-xs text-neutral-muted">
                    @if($event->payment_method === 'upfront')
                        Peserta harus membayar sebelum event dimulai.
                    @elseif($event->payment_method === 'onsite')
                        Peserta membayar langsung di lokasi saat hari pelaksanaan.
                    @else
                        Tidak ada biaya pendaftaran.
                    @endif
                </p>
            </div>
        </div>
        @if($event->payment_info)
            <div class="mt-4 pt-4 border-t border-neutral-border">
                <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Info Pembayaran</p>
                <p class="text-sm text-neutral-text whitespace-pre-line">{{ $event->payment_info }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
