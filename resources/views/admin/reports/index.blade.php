@extends('layouts.admin', ['activeNav' => 'reports', 'pageTitle' => 'Laporan Event', 'breadcrumbs' => [['label' => 'Laporan Event']]])

@section('title', 'Laporan Event')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Laporan Event</h2>
                <p class="text-sm text-neutral-muted">Review laporan dari pengguna tentang event bermasalah.</p>
            </div>
            @if($pendingCount > 0)
                <span class="px-3 py-1.5 bg-error-light text-error text-sm font-semibold rounded-full">{{ $pendingCount }} pending</span>
            @endif
        </div>

        <!-- Filter -->
        <form method="GET" class="bg-white rounded-2xl border border-neutral-border p-4 shadow-xs flex items-center gap-3">
            <select name="status" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border focus:border-primary outline-none" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Diselesaikan</option>
                <option value="dismissed" {{ request('status') === 'dismissed' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </form>

        <!-- Reports List -->
        <div class="space-y-4">
            @forelse($reports as $report)
                <div class="bg-white rounded-2xl border border-neutral-border shadow-sm p-6 hover:shadow-md transition-shadow">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-base font-bold text-neutral-text font-poppins truncate">
                                    <a href="{{ route('admin.events.show', $report->event) }}" class="hover:text-primary transition-colors">{{ $report->event->title ?? 'Event dihapus' }}</a>
                                </h3>
                                @php($statusColors = ['pending' => 'warning', 'resolved' => 'success', 'dismissed' => 'neutral'])
                                <x-badge variant="{{ $statusColors[$report->status] ?? 'neutral' }}" size="sm">{{ ucfirst($report->status) }}</x-badge>
                            </div>
                            <div class="flex flex-wrap gap-x-3 gap-y-1 text-xs text-neutral-muted mb-2">
                                <span>👤 {{ $report->user->name ?? '—' }}</span>
                                <span>•</span>
                                <span>Alasan: <strong>{{ $report->reason_label }}</strong></span>
                                <span>•</span>
                                <span>{{ $report->created_at->diffForHumans() }}</span>
                            </div>
                            @if($report->description)
                                <p class="text-sm text-neutral-muted line-clamp-2">{{ $report->description }}</p>
                            @endif
                            @if($report->admin_notes)
                                <div class="mt-2 p-3 bg-neutral-bg rounded-lg text-xs">
                                    <span class="font-semibold text-neutral-muted">Catatan Admin:</span>
                                    <span class="text-neutral-text">{{ $report->admin_notes }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('admin.reports.show', $report) }}" class="px-4 py-2 text-sm font-semibold text-primary border border-primary/20 rounded-xl hover:bg-primary-light transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-success mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-lg font-semibold text-neutral-text mb-2">Tidak ada laporan 🎉</h3>
                    <p class="text-sm text-neutral-muted">Semua event dalam kondisi baik.</p>
                </div>
            @endforelse
        </div>

        @if($reports->hasPages())
            <div class="flex justify-center">{{ $reports->links() }}</div>
        @endif
    </div>
@endsection
