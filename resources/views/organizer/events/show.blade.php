@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Detail Event', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => route('organizer.events.index')], ['label' => $event->title]]])

@section('title', $event->title)

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
    @endif
    @if($errors->any())
        <x-alert type="error" dismissible="true">{{ $errors->first() }}</x-alert>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-neutral-text font-poppins">{{ $event->title }}</h2>
            <p class="text-sm text-neutral-muted mt-1">Created {{ $event->created_at->diffForHumans() }}</p>
        </div>
        <div class="flex items-center gap-2">
            @php($statusColors = ['published' => 'success', 'draft' => 'warning', 'pending' => 'info', 'rejected' => 'danger', 'cancelled' => 'neutral'])
            <x-badge variant="{{ $statusColors[$event->status] ?? 'neutral' }}">{{ ucfirst($event->status) }}</x-badge>

            @if(in_array($event->status, ['draft', 'rejected']))
                <a href="{{ route('organizer.events.edit', $event) }}" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">Edit</a>
            @endif

            <a href="{{ route('organizer.events.analytics', $event) }}" class="px-4 py-2 text-sm font-semibold text-info border border-info/20 rounded-xl hover:bg-info-light transition-colors">📊 Analytics</a>

            <form method="POST" action="{{ route('organizer.events.clone', $event) }}" class="inline" onsubmit="return confirm('Duplikasi event ini sebagai draft baru?')">
                @csrf
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-warning border border-warning/20 rounded-xl hover:bg-warning-light transition-colors">📋 Duplikat</button>
            </form>

            @if(in_array($event->status, ['draft', 'pending', 'published']))
                <form action="{{ route('organizer.events.cancel', $event) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan event ini?')">
                    @csrf
                    <button type="submit" class="px-4 py-2 text-sm font-semibold text-error bg-error-light rounded-xl hover:bg-error hover:text-white transition-colors border border-error/20">Batalkan Event</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Rejection Reason -->
    @if($event->status === 'rejected' && $event->rejection_reason)
        <x-alert type="error" title="Alasan Penolakan">{{ $event->rejection_reason }}</x-alert>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $registeredCount }}</p><p class="text-xs text-neutral-muted">Pendaftar</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-success-light text-success flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $event->capacity ?? 'Unlimited' }}</p><p class="text-xs text-neutral-muted">Kapasitas</p></div>
        </div>
        <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-info-light text-info flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div><p class="text-2xl font-bold text-neutral-text font-poppins">{{ $slotsRemaining !== null ? $slotsRemaining : 'Unlimited' }}</p><p class="text-xs text-neutral-muted">Slot Tersisa</p></div>
        </div>
    </div>

    <!-- Event Details -->
    <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
        <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Detail Event</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div><span class="font-semibold text-neutral-muted">Kategori:</span> <span class="text-neutral-text">{{ $event->category->name ?? '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Jenis:</span> <span class="text-neutral-text">{{ $event->eventType->name ?? '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Format:</span> <span class="text-neutral-text">{{ $event->eventFormat->name ?? '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Kota:</span> <span class="text-neutral-text">{{ $event->city->name ?? '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Mulai:</span> <span class="text-neutral-text">{{ $event->start_at ? $event->start_at->format('d M Y, H:i') : '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Selesai:</span> <span class="text-neutral-text">{{ $event->end_at ? $event->end_at->format('d M Y, H:i') : '---' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Lokasi:</span> <span class="text-neutral-text">{{ $event->location ?? 'Online' }}</span></div>
            <div><span class="font-semibold text-neutral-muted">Online URL:</span> <span class="text-neutral-text">{{ $event->online_url ?? '---' }}</span></div>
        </div>
        @if($event->description)
            <div class="mt-4 pt-4 border-t border-neutral-border">
                <p class="text-sm font-semibold text-neutral-muted mb-2">Deskripsi:</p>
                <div class="text-sm text-neutral-text prose prose-sm">{!! nl2br(e($event->description)) !!}</div>
            </div>
        @endif
    </div>


    <!-- Registration Period -->
    <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
        <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Masa Registrasi</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Dibuka</p>
                <p class="text-neutral-text">{{ $event->created_at->format('d M Y, H:i') }}</p>
                <p class="text-xs text-neutral-muted">{{ $event->created_at->diffForHumans() }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Batas Registrasi</p>
                @if($event->registration_deadline)
                    <p class="text-neutral-text {{ $event->registration_deadline->isPast() ? 'text-error font-semibold' : '' }}">{{ $event->registration_deadline->format('d M Y, H:i') }}</p>
                    <p class="text-xs {{ $event->registration_deadline->isPast() ? 'text-error' : 'text-neutral-muted' }}">
                        @if($event->registration_deadline->isPast()) Sudah ditutup @else {{ $event->registration_deadline->diffForHumans() }} lagi @endif
                    </p>
                @else
                    <p class="text-neutral-text">Sampai hari pelaksanaan</p>
                    @if($event->start_at)
                        <p class="text-xs text-neutral-muted">{{ $event->start_at->format('d M Y, H:i') }}</p>
                    @endif
                @endif
            </div>
        </div>
        @php($totalRegs = $event->registrations()->count())
        @php($activeRegs = $event->registrations()->whereIn('status', ['registered', 'pending_payment'])->count())
        <div class="mt-4 pt-4 border-t border-neutral-border">
            <div class="flex items-center gap-6 text-sm">
                <div>
                    <span class="text-neutral-muted">Total Pendaftar:</span>
                    <span class="font-semibold text-neutral-text ml-1">{{ $totalRegs }}</span>
                </div>
                <div>
                    <span class="text-neutral-muted">Aktif:</span>
                    <span class="font-semibold text-success ml-1">{{ $activeRegs }}</span>
                </div>
                @if($event->capacity)
                    <div>
                        <span class="text-neutral-muted">Slot Tersisa:</span>
                        <span class="font-semibold {{ $event->capacity - $activeRegs <= 0 ? 'text-error' : 'text-primary' }} ml-1">{{ max(0, $event->capacity - $activeRegs) }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Registrations -->
    <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-neutral-text font-poppins">Pendaftar Terbaru</h3>
            <a href="{{ route('organizer.events.registrations', $event) }}" class="text-xs font-semibold text-primary hover:text-primary-hover">Lihat Semua &#8594;</a>
        </div>
        @if($event->registrations->count())
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-text">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-text">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-xs">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-neutral-text">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-border">
                        @foreach($event->registrations->take(5) as $reg)
                            <tr>
                                <td class="px-4 py-3 text-sm text-neutral-text">{{ $reg->user->name ?? '---' }}</td>
                                <td class="px-4 py-3 text-sm text-neutral-muted">{{ $reg->user->email ?? '---' }}</td>
                                <td class="px-4 py-3"><code class="text-xs bg-neutral-bg px-2 py-1 rounded">{{ $reg->registration_code }}</code></td>
                                <td class="px-4 py-3">
                                    @if($reg->status === "registered")
                                        <x-badge variant="success" size="sm">Registered</x-badge>
                                    @elseif($reg->status === "attended")
                                        <x-badge variant="success" size="sm">Hadir</x-badge>
                                    @elseif($reg->status === "no_show")
                                        <x-badge variant="error" size="sm">No-Show</x-badge>
                                    @else
                                        <x-badge variant="neutral" size="sm">{{ ucfirst($reg->status) }}</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-sm text-neutral-muted text-center py-4">Belum ada pendaftar.</p>
        @endif
    </div>
</div>
@endsection
