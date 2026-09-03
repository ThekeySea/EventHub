@extends('layouts.member')
@php($activeNav = 'notifications')
@php($pageTitle = 'Notifikasi')
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

@if($notifications->count())
    <div class="space-y-3">
        @foreach($notifications as $notif)
            <div class="bg-white rounded-2xl border p-5 shadow-sm transition-all hover:shadow-md {{ $notif->is_read ? 'border-neutral-border' : 'border-primary/30 bg-primary-light/30' }}">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $notif->type === 'event_approved' ? 'bg-success-light text-success' : '' }}
                        {{ $notif->type === 'event_rejected' ? 'bg-error-light text-error' : '' }}
                        {{ $notif->type === 'registration_success' ? 'bg-primary-light text-primary' : '' }}
                        {{ $notif->type === 'registration_cancelled' ? 'bg-warning-light text-warning' : '' }}
                        {{ !in_array($notif->type, ['event_approved','event_rejected','registration_success','registration_cancelled']) ? 'bg-neutral-bg text-neutral-muted' : '' }}">
                        @if($notif->type === 'event_approved')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @elseif($notif->type === 'event_rejected')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @elseif($notif->type === 'registration_success')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-neutral-text">{{ $notif->title }}</h3>
                            @if(!$notif->is_read)
                                <span class="w-2 h-2 rounded-full bg-primary shrink-0"></span>
                            @endif
                        </div>
                        <p class="text-sm text-neutral-muted mt-1">{{ $notif->message }}</p>
                        <p class="text-xs text-neutral-muted/70 mt-2">{{ $notif->created_at->locale('id')->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if(!$notif->is_read)
                            <form method="POST" action="{{ route('notifications.markAsRead', $notif) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-primary border border-primary/20 rounded-lg hover:bg-primary-light transition-colors">
                                    Dibaca
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('notifications.destroy', $notif) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-neutral-muted hover:text-error rounded-lg hover:bg-error-light transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $notifications->links() }}
    </div>
@else
    <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center shadow-sm">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-neutral-bg text-neutral-muted flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </div>
        <h3 class="text-lg font-bold text-neutral-text font-poppins mb-2">Belum Ada Notifikasi</h3>
        <p class="text-sm text-neutral-muted">Notifikasi akan muncul di sini.</p>
    </div>
@endif

@endsection
