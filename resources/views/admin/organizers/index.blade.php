@extends('layouts.admin', ['activeNav' => 'organizer-performance', 'pageTitle' => 'Kinerja Organizer', 'breadcrumbs' => [['label' => 'Kinerja Organizer']]])

@section('title', 'Kinerja Organizer')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">Kinerja Organizer</h2>
            <p class="text-sm text-neutral-muted">Metrik kinerja setiap organizer di platform.</p>
        </div>

        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            @if($organizers->count())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase">Organizer</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Total Event</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Published</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Rasio Publish</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Total Registrasi</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Avg per Event</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">No-Show Rate</th>
                                <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-text uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($organizers as $org)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-primary-light text-primary font-bold text-xs flex items-center justify-center">{{ strtoupper(substr($org->name, 0, 2)) }}</div>
                                            <div>
                                                <p class="text-sm font-semibold text-neutral-text">{{ $org->name }}</p>
                                                <p class="text-xs text-neutral-muted">{{ $org->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-medium text-neutral-text">{{ $org->total_events }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-medium text-success">{{ $org->published_events }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php($rateColor = $org->publish_rate >= 70 ? 'success' : ($org->publish_rate >= 40 ? 'warning' : 'error'))
                                        <span class="text-sm font-semibold text-{{ $rateColor }}">{{ $org->publish_rate }}%</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-medium text-neutral-text">{{ $org->total_registrations }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-medium text-info">{{ $org->avg_registrations }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php($nshColor = $org->no_show_rate <= 10 ? 'success' : ($org->no_show_rate <= 30 ? 'warning' : 'error'))
                                        <span class="text-sm font-semibold text-{{ $nshColor }}">{{ $org->no_show_rate }}%</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($org->is_problematic)
                                            <x-badge variant="error" size="sm">⚠ Bermasalah</x-badge>
                                        @else
                                            <x-badge variant="success" size="sm">Baik</x-badge>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <p class="text-sm text-neutral-muted">Belum ada organizer terdaftar.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
