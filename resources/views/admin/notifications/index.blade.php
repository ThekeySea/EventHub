@extends('layouts.admin', ['activeNav' => 'notifications', 'pageTitle' => 'Notifikasi'])
@section('title', 'Notifikasi')
@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-neutral-text font-poppins">Notifikasi</h1>
        <p class="text-sm text-neutral-muted mt-1">{{ $unreadCount }} belum dibaca</p>
    </div>
    @if($unreadCount > 0)
        <form method="POST" action="{{ route('notifications.markAllRead') }}">
            @csrf @method('PATCH')
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-primary border border-primary/20 rounded-xl hover:bg-primary-light transition-colors">
                Tandai Semua Dibaca
            </button>
        </form>
    @endif
</div>

@if($notifications->isEmpty())
    <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center">
        <div class="w-16 h-16 rounded-2xl bg-neutral-bg border border-neutral-border text-neutral-muted flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <h3 class="text-base font-semibold text-neutral-text font-poppins mb-1">Tidak ada notifikasi</h3>
        <p class="text-sm text-neutral-muted">Notifikasi baru akan muncul di sini.</p>
    </div>
@else
    <div class="bg-white rounded-2xl border border-neutral-border shadow-sm divide-y divide-neutral-border">
        @foreach($notifications as $notification)
            <div class="p-4 sm:p-5 {{ $notification->read_at ? 'opacity-60' : 'bg-primary-light/30' }} hover:bg-neutral-bg/50 transition-colors">
                <div class="flex items-start gap-3">
                    @if(!$notification->read_at)
                        <div class="w-2 h-2 rounded-full bg-primary mt-2 shrink-0"></div>
                    @else
                        <div class="w-2 h-2 shrink-0"></div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-neutral-text">{{ $notification->title }}</p>
                        <p class="text-sm text-neutral-muted mt-0.5">{{ $notification->message }}</p>
                        <div class="flex items-center gap-3 mt-2">
                            <span class="text-xs text-neutral-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            @if($notification->action_url)
                                <a href="{{ $notification->action_url }}" class="text-xs font-semibold text-primary hover:text-primary-hover">Lihat</a>
                            @endif
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.markAsRead', $notification) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs text-neutral-muted hover:text-neutral-text">Tandai dibaca</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <form method="POST" action="{{ route('notifications.destroy', $notification) }}">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-neutral-muted hover:text-error transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    @if($notifications->hasPages())
        <div class="mt-4">{{ $notifications->links() }}</div>
    @endif
@endif

@endsection
