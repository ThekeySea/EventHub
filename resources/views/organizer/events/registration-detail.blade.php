@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Detail Registrasi', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => route('organizer.events.index')], ['label' => $event->title, 'url' => route('organizer.events.show', $event)], ['label' => 'Registrasi']]])

@section('title', 'Detail Registrasi — ' . $event->title)

@section('content')
<div class="space-y-6">
    @if(session('success'))
        <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
    @endif

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-neutral-text font-poppins">{{ $registration->user->name }}</h2>
            <p class="text-sm text-neutral-muted mt-1">Registrasi untuk event "{{ $event->title }}"</p>
        </div>
        <a href="{{ route('organizer.events.registrations', $event) }}" class="px-4 py-2 text-sm font-semibold text-neutral-text border border-neutral-border rounded-xl hover:bg-neutral-bg transition-colors">
            ← Kembali ke Daftar
        </a>
    </div>

    <!-- Registration Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Informasi Pendaftar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Nama</p>
                        <p class="text-sm text-neutral-text">{{ $registration->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm text-neutral-text">{{ $registration->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Telepon</p>
                        <p class="text-sm text-neutral-text">{{ $registration->user->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Kode Registrasi</p>
                        <code class="text-sm bg-neutral-bg px-2 py-1 rounded">{{ $registration->registration_code }}</code>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Status</p>
                        @php($statusColors = ['registered' => 'success', 'pending_payment' => 'warning', 'attended' => 'info', 'cancelled' => 'error', 'no_show' => 'error', 'waitlisted' => 'neutral'])
                        <x-badge variant="{{ $statusColors[$registration->status] ?? 'neutral' }}">{{ ucfirst(str_replace('_', ' ', $registration->status)) }}</x-badge>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Waktu Daftar</p>
                        <p class="text-sm text-neutral-text">{{ $registration->registered_at ? $registration->registered_at->format('d M Y, H:i') : '—' }}</p>
                    </div>
                    @if($registration->payment_confirmed_at)
                        <div>
                            <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Pembayaran Dikonfirmasi</p>
                            <p class="text-sm text-neutral-text">{{ $registration->payment_confirmed_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                    @if($registration->checked_in_at)
                        <div>
                            <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Waktu Check-in</p>
                            <p class="text-sm text-neutral-text">{{ $registration->checked_in_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Registration Log Timeline -->
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Riwayat Status</h3>
                @if($registration->logs->count())
                    <div class="space-y-4">
                        @foreach($registration->logs->sortByDesc('created_at') as $log)
                            <div class="flex items-start gap-3">
                                @php($logColors = ['created' => 'bg-primary', 'payment_confirmed' => 'bg-success', 'checked_in' => 'bg-info', 'no_show' => 'bg-error', 'cancelled' => 'bg-neutral-muted', 'waitlisted' => 'bg-warning', 'promoted' => 'bg-success'])
                                <div class="w-3 h-3 rounded-full {{ $logColors[$log->action] ?? 'bg-neutral-border' }} mt-1.5 shrink-0"></div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-text">{{ $log->action_label }}</p>
                                    @if($log->notes)
                                        <p class="text-xs text-neutral-muted mt-0.5">{{ $log->notes }}</p>
                                    @endif
                                    <p class="text-xs text-neutral-muted">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-neutral-muted text-center py-4">Belum ada riwayat.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm sticky top-24 space-y-4">
                <h3 class="text-lg font-bold text-neutral-text font-poppins">Aksi</h3>

                @if(in_array($registration->status, ['registered']))
                    @if($event->start_at && $event->start_at->isPast())
                        <div class="grid grid-cols-2 gap-2">
                            <form action="{{ route('organizer.events.checkin', [$event, $registration]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="action" value="checkin">
                                <button type="submit" class="w-full py-2.5 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 transition-colors">✓ Hadir</button>
                            </form>
                            <form action="{{ route('organizer.events.checkin', [$event, $registration]) }}" method="POST" onsubmit="return confirm('Tandai sebagai tidak hadir?')">
                                @csrf
                                <input type="hidden" name="action" value="noshow">
                                <button type="submit" class="w-full py-2.5 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 transition-colors">✕ No-Show</button>
                            </form>
                        </div>
                    @else
                        <p class="text-xs text-neutral-muted text-center">Check-in tersedia saat event dimulai.</p>
                    @endif
                @endif

                @if($registration->status === 'pending_payment' && $event->payment_method === 'upfront')
                    <form action="{{ route('organizer.events.confirm-payment', [$event, $registration]) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran diterima?')">
                        @csrf
                    
                        <button type="submit" class="w-full py-2.5 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 transition-colors">💰 Konfirmasi Pembayaran</button>
                    </form>
                @endif

                <div class="pt-4 border-t border-neutral-border">
                    <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="block text-center text-xs font-semibold text-primary hover:text-primary-hover transition-colors">
                        Lihat Event di Publik →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
