@extends('layouts.member')
@php($activeNav = 'registrations')
@php($pageTitle = 'Registrasi Saya')
@section('title', 'Registrasi Saya')
@section('content')

    <div class="bg-white border-b border-neutral-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-bold font-poppins text-neutral-text">My Registrations</h1>
            <p class="text-sm text-neutral-muted mt-1">Daftar event yang sudah Anda daftarkan</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 mb-6">
            <a href="{{ route('member.registrations') }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ !request('status') ? 'bg-primary text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                Semua <span class="ml-1 text-xs opacity-75">({{ $totalRegistered + $totalAttended + $totalCancelled + $totalPendingPayment + $totalNoShow }})</span>
            </a>
            <a href="{{ route('member.registrations', ['status' => 'registered']) }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ request('status') === 'registered' ? 'bg-success text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                Aktif <span class="ml-1 text-xs opacity-75">({{ $totalRegistered }})</span>
            </a>
            <a href="{{ route('member.registrations', ['status' => 'attended']) }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ request('status') === 'attended' ? 'bg-info text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                Hadir <span class="ml-1 text-xs opacity-75">({{ $totalAttended }})</span>
            </a>
            <a href="{{ route('member.registrations', ['status' => 'pending_payment']) }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ request('status') === 'pending_payment' ? 'bg-warning text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                Menunggu Bayar <span class="ml-1 text-xs opacity-75">({{ $totalPendingPayment }})</span>
            </a>
            <a href="{{ route('member.registrations', ['status' => 'cancelled']) }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ request('status') === 'cancelled' ? 'bg-error text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                Dibatalkan <span class="ml-1 text-xs opacity-75">({{ $totalCancelled }})</span>
            </a>
            <a href="{{ route('member.registrations', ['status' => 'no_show']) }}" class="px-4 py-2 text-sm font-semibold rounded-xl transition-colors {{ request('status') === 'no_show' ? 'bg-error text-white' : 'bg-white text-neutral-muted border border-neutral-border hover:bg-neutral-bg' }}">
                No-Show <span class="ml-1 text-xs opacity-75">({{ $totalNoShow }})</span>
            </a>
        </div>

        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        @if($registrations->count())
            <div class="space-y-4">
                @foreach($registrations as $reg)
                    <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-base font-bold text-neutral-text font-poppins truncate">
                                        <a href="{{ route('events.show', $reg->event->slug) }}" class="hover:text-primary transition-colors">
                                            {{ $reg->event->title }}
                                        </a>
                                    </h3>
                                    @php($statusVariant = match($reg->status) {
                                        'registered' => 'success',
                                        'cancelled' => 'error',
                                        'attended' => 'info',
                                        'pending_payment' => 'warning',
                                        'no_show' => 'error',
                                        default => 'neutral',
                                    })
                                    <x-badge variant="{{ $statusVariant }}" size="sm">{{ ucfirst($reg->status) }}</x-badge>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-neutral-muted mt-1">
                                    <span>📂 {{ $reg->event->category->name ?? '—' }}</span>
                                    <span>📅 {{ $reg->event->start_at ? $reg->event->start_at->locale('id')->translatedFormat('d M Y, H:i') : '—' }}</span>
                                    <span>📍 {{ $reg->event->city->name ?? $reg->event->location ?? 'Online' }}</span>
                                </div>
                                <p class="text-xs text-neutral-muted mt-1">Kode: {{ $reg->registration_code }} • Daftar: {{ $reg->registered_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
                                @if($reg->status === 'pending_payment' && $reg->event->payment_info)
                                    <div class="mt-2 p-2 rounded-lg bg-warning-light/30 border border-warning/20">
                                        <p class="text-[10px] font-semibold text-warning">Menunggu konfirmasi pembayaran oleh organizer.</p>
                                        <p class="text-[10px] text-neutral-muted mt-0.5 whitespace-pre-line">{{ $reg->event->payment_info }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ route('events.show', $reg->event->slug) }}" class="px-3 py-1.5 text-xs font-semibold text-primary border border-primary/20 rounded-lg hover:bg-primary-light transition-colors">
                                    Lihat Event
                                </a>
                                @if($reg->status === 'registered' && !$reg->event->start_at->isPast())
                                    <form action="{{ route('member.registrations.destroy', $reg) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan registrasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-error bg-error-light rounded-lg hover:bg-error hover:text-white transition-colors border border-error/20">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $registrations->links() }}
            </div>
        @else
            <x-empty-state 
                title="Belum ada registrasi"
                description="Jelajahi event seru dan daftarkan diri kamu untuk pertama kalinya!"
                actionText="Jelajahi Event"
                :actionHref="route('events.index')"
            />
        @endif
    </div>

@endsection
