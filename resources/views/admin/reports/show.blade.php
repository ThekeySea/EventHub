@extends('layouts.admin', ['activeNav' => 'reports', 'pageTitle' => 'Detail Laporan', 'breadcrumbs' => [['label' => 'Laporan Event', 'url' => route('admin.reports.index')], ['label' => 'Detail']]])

@section('title', 'Detail Laporan')

@section('content')
    <div class="w-full min-w-0 max-w-4xl mx-auto space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-neutral-text font-poppins">Detail Laporan</h2>
                <p class="text-sm text-neutral-muted mt-1">Laporan dari {{ $report->user->name }} tentang event "{{ $report->event->title ?? 'Dihapus' }}"</p>
            </div>
            @php($statusColors = ['pending' => 'warning', 'resolved' => 'success', 'dismissed' => 'neutral'])
            <x-badge variant="{{ $statusColors[$report->status] ?? 'neutral' }}">{{ ucfirst($report->status) }}</x-badge>
        </div>

        <!-- Report Info -->
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Pelapor</p>
                    <p class="text-sm text-neutral-text">{{ $report->user->name }} ({{ $report->user->email }})</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Waktu Lapor</p>
                    <p class="text-sm text-neutral-text">{{ $report->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Alasan</p>
                    <x-badge variant="warning" size="sm">{{ $report->reason_label }}</x-badge>
                </div>
                <div>
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-1">Event</p>
                    @if($report->event)
                        <a href="{{ route('admin.events.show', $report->event) }}" class="text-sm text-primary hover:text-primary-hover font-medium">{{ $report->event->title }}</a>
                    @else
                        <p class="text-sm text-neutral-muted">Event sudah dihapus</p>
                    @endif
                </div>
            </div>

            @if($report->description)
                <div class="pt-4 border-t border-neutral-border">
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-2">Deskripsi Laporan</p>
                    <p class="text-sm text-neutral-text bg-neutral-bg rounded-xl p-4">{{ $report->description }}</p>
                </div>
            @endif

            @if($report->admin_notes)
                <div class="pt-4 border-t border-neutral-border">
                    <p class="text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-2">Catatan Admin</p>
                    <p class="text-sm text-neutral-text bg-neutral-bg rounded-xl p-4">{{ $report->admin_notes }}</p>
                    @if($report->reviewer)
                        <p class="text-xs text-neutral-muted mt-1">Oleh: {{ $report->reviewer->name }} • {{ $report->updated_at->diffForHumans() }}</p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Action Buttons (only for pending reports) -->
        @if($report->status === 'pending')
            <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6" x-data="{ showResolve: false, showDismiss: false }">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-4">Tindakan</h3>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="showResolve = !showResolve" class="px-6 py-3 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Selesaikan Laporan
                    </button>
                    <button type="button" @click="showDismiss = !showDismiss" class="px-6 py-3 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl border border-neutral-border hover:bg-neutral-border transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tolak Laporan
                    </button>
                </div>

                <!-- Resolve Form -->
                <div x-show="showResolve" x-cloak x-transition class="mt-6 pt-6 border-t border-neutral-border">
                    <form action="{{ route('admin.reports.resolve', $report) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-neutral-text mb-2">Catatan (opsional)</label>
                            <textarea name="admin_notes" placeholder="Catatan tentang tindakan yang diambil..." class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-success focus:ring-2 focus:ring-success/20 outline-none transition-all min-h-[80px]"></textarea>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="showResolve = false" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-success text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">Konfirmasi Selesai</button>
                        </div>
                    </form>
                </div>

                <!-- Dismiss Form -->
                <div x-show="showDismiss" x-cloak x-transition class="mt-6 pt-6 border-t border-neutral-border">
                    <form action="{{ route('admin.reports.dismiss', $report) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-neutral-text mb-2">Alasan Penolakan (opsional)</label>
                            <textarea name="admin_notes" placeholder="Mengapa laporan ini ditolak..." class="w-full rounded-xl border border-neutral-border bg-white p-3 text-sm focus:border-error focus:ring-2 focus:ring-error/20 outline-none transition-all min-h-[80px]"></textarea>
                        </div>
                        <div class="flex gap-2 justify-end">
                            <button type="button" @click="showDismiss = false" class="px-4 py-2 text-sm font-semibold text-neutral-text rounded-xl hover:bg-neutral-bg transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 bg-error text-white text-sm font-semibold rounded-xl hover:opacity-90 shadow-sm transition-all">Tolak Laporan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
