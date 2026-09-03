@extends('layouts.admin', ['activeNav' => 'audit-logs', 'pageTitle' => 'Audit Log', 'breadcrumbs' => [['label' => 'Audit Log']]])

@section('title', 'Audit Log')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        @if(session('success'))
            <x-alert type="success" dismissible="true">{{ session('success') }}</x-alert>
        @endif

        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Audit Log</h2>
            <p class="text-sm text-neutral-muted">Riwayat semua aksi penting di platform.</p>
        </div>

        <!-- Filter -->
        <form method="GET" class="bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select name="action" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border focus:border-primary outline-none">
                    <option value="">Semua Aksi</option>
                    @foreach($actions as $action)
                        <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $action)) }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border focus:border-primary outline-none" placeholder="Dari tanggal">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border focus:border-primary outline-none" placeholder="Sampai tanggal">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">Filter</button>
                @if(request('action') || request('date_from') || request('date_to'))
                    <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-border transition-colors">Reset</a>
                @endif
            </div>
        </form>

        <!-- Log Table -->
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-neutral-border/60">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">{{ $logs->total() }} log ditemukan</span>
            </div>

            @if($logs->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase">Pelaku</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase">Aksi</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase hidden md:table-cell">Objek</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase hidden lg:table-cell">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($logs as $log)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-6 py-4 text-xs text-neutral-muted whitespace-nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-neutral-text">{{ $log->user->name ?? '—' }}</div>
                                        <div class="text-xs text-neutral-muted">{{ $log->ip_address ?? '—' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php($actionColors = [
                                            'event_approved' => 'success',
                                            'event_rejected' => 'error',
                                            'event_deleted' => 'error',
                                            'event_created' => 'info',
                                            'event_submitted' => 'warning',
                                            'event_cancelled' => 'neutral',
                                            'user_role_changed' => 'warning',
                                            'report_resolved' => 'success',
                                            'report_dismissed' => 'neutral',
                                        ])
                                        <x-badge variant="{{ $actionColors[$log->action] ?? 'neutral' }}" size="sm">{{ $log->action_label }}</x-badge>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell text-sm text-neutral-muted">
                                        {{ class_basename($log->subject_type) }} #{{ $log->subject_id }}
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if($log->old_values || $log->new_values)
                                            <button type="button" onclick="document.getElementById('detail-{{ $log->id }}').classList.toggle('hidden')" class="text-xs text-primary hover:text-primary-hover font-medium">
                                                Lihat Detail
                                            </button>
                                            <div id="detail-{{ $log->id }}" class="hidden mt-2 p-3 bg-neutral-bg rounded-lg text-xs space-y-1">
                                                @if($log->old_values)
                                                    <p class="font-semibold text-neutral-muted">Sebelum:</p>
                                                    @foreach($log->old_values as $key => $val)
                                                        <p class="text-neutral-text">{{ $key }}: {{ is_array($val) ? json_encode($val) : $val }}</p>
                                                    @endforeach
                                                @endif
                                                @if($log->new_values)
                                                    <p class="font-semibold text-neutral-muted mt-2">Sesudah:</p>
                                                    @foreach($log->new_values as $key => $val)
                                                        <p class="text-neutral-text">{{ $key }}: {{ is_array($val) ? json_encode($val) : $val }}</p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-xs text-neutral-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-border">{{ $logs->links() }}</div>
                @endif
            @else
                <div class="p-12 text-center">
                    
                    <p class="text-sm text-neutral-muted">Belum ada audit log.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
