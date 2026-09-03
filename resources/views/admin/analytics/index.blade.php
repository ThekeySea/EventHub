@extends('layouts.admin', ['activeNav' => 'analytics', 'pageTitle' => 'Analytics Dashboard', 'breadcrumbs' => [['label' => 'Analytics']]])

@section('title', 'Analytics Dashboard - Admin')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div class="w-full min-w-0">
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Analytics Dashboard</h2>
            <p class="text-sm text-neutral-muted">Monitor website activity and user engagement.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-neutral-muted">Total Users</span>
                    <div class="w-10 h-10 rounded-xl bg-primary-light text-primary flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                </div>
                <p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-neutral-muted">Pengguna Aktif</span>
                    <div class="w-10 h-10 rounded-xl bg-success-light text-success flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                </div>
                <p class="text-2xl font-bold text-neutral-text font-poppins">{{ $activeUsers }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-neutral-muted">Total Events</span>
                    <div class="w-10 h-10 rounded-xl bg-info-light text-info flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                </div>
                <p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalEvents }}</p>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-border p-5 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-neutral-muted">Total Registrations</span>
                    <div class="w-10 h-10 rounded-xl bg-warning-light text-warning flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg></div>
                </div>
                <p class="text-2xl font-bold text-neutral-text font-poppins">{{ $totalRegistrations }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-1">User Baru per Minggu</h3>
                <p class="text-xs text-neutral-muted mb-4">8 minggu terakhir</p>
                <div class="relative" style="height: 250px;"><canvas id="userChart"></canvas></div>
            </div>
            <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
                <h3 class="text-lg font-bold text-neutral-text font-poppins mb-1">Event per Bulan</h3>
                <p class="text-xs text-neutral-muted mb-4">6 bulan terakhir (per status)</p>
                <div class="relative" style="height: 250px;"><canvas id="eventChart"></canvas></div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm">
            <h3 class="text-lg font-bold text-neutral-text font-poppins mb-1">Trend Registrasi</h3>
            <p class="text-xs text-neutral-muted mb-4">8 minggu terakhir</p>
            <div class="relative" style="height: 280px;"><canvas id="registrationChart"></canvas></div>
        </div>
    </div>
@endsection

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const primaryColor = '#6366F1';
    const successColor = '#22C55E';
    const warningColor = '#F59E0B';
    const infoColor = '#3B82F6';

    new Chart(document.getElementById('userChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($weeks->pluck('label')) !!},
            datasets: [{ label: 'User Baru', data: {!! json_encode($weeks->pluck('count')) !!}, borderColor: primaryColor, backgroundColor: primaryColor+'20', fill: true, tension: 0.4, pointBackgroundColor: primaryColor, pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('eventChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($months->pluck('label')) !!},
            datasets: [
                { label: 'Published', data: {!! json_encode($months->pluck('published')) !!}, backgroundColor: successColor, borderRadius: 6 },
                { label: 'Pending', data: {!! json_encode($months->pluck('pending')) !!}, backgroundColor: warningColor, borderRadius: 6 },
                { label: 'Draft', data: {!! json_encode($months->pluck('draft')) !!}, backgroundColor: infoColor, borderRadius: 6 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'top', labels: { usePointStyle: true, pointStyle: 'circle', padding: 15 } } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } } }
    });

    new Chart(document.getElementById('registrationChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($regWeeks->pluck('label')) !!},
            datasets: [{ label: 'Registrasi', data: {!! json_encode($regWeeks->pluck('count')) !!}, borderColor: successColor, backgroundColor: successColor+'20', fill: true, tension: 0.4, pointBackgroundColor: successColor, pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 5 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } } }
    });
});
</script>
@endpush
