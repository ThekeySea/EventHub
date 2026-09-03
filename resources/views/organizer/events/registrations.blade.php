@extends('layouts.organizer', ['activeNav' => 'events', 'pageTitle' => 'Pendaftar Event', 'breadcrumbs' => [['label' => 'Event Saya', 'url' => route('organizer.events.index')], ['label' => $event->title, 'url' => route('organizer.events.show', $event)], ['label' => 'Pendaftar']]])

@section('title', 'Registrations - ' . $event->title)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-neutral-text font-poppins">Pendaftar: {{ $event->title }}</h2>
        <p class="text-sm text-neutral-muted mt-1">{{ $registrations->total() }} pendaftar ditemukan</p>
    </div>

    @if($registrations->count())
        <div class="bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">Kode Registrasi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">Waktu Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-border">
                        @foreach($registrations as $index => $reg)
                            <tr class="hover:bg-neutral-bg/30 transition-colors">
                                <td class="px-6 py-4 text-sm text-neutral-muted">{{ $registrations->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary-light text-primary text-xs font-bold flex items-center justify-center">{{ strtoupper(substr($reg->user->name ?? '?', 0, 2)) }}</div>
                                        <span class="text-sm font-medium text-neutral-text">{{ $reg->user->name ?? '---' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-neutral-muted">{{ $reg->user->email ?? '---' }}</td>
                                <td class="px-6 py-4"><code class="text-xs bg-neutral-bg px-2 py-1 rounded text-neutral-text">{{ $reg->registration_code }}</code></td>
                                <td class="px-6 py-4 text-sm text-neutral-muted">{{ $reg->registered_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4">
                                    @if($reg->status === 'registered')
                                        <div class="flex items-center gap-2">
                                            <x-badge variant="success" size="sm">Registered</x-badge>
                                            <form action="{{ route('organizer.events.checkin', [$event, $reg]) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="action" value="checkin">
                                                <button type="submit" class="px-2 py-1 text-[10px] font-semibold bg-success/10 text-success rounded-lg hover:bg-success hover:text-white transition-colors">Hadir</button>
                                            </form>
                                            <form action="{{ route('organizer.events.checkin', [$event, $reg]) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="action" value="noshow">
                                                <button type="submit" onclick="return confirm('Tandai tidak hadir?')" class="px-2 py-1 text-[10px] font-semibold bg-error/10 text-error rounded-lg hover:bg-error hover:text-white transition-colors">No-Show</button>
                                            </form>
                                        </div>
                                    @elseif($reg->status === 'attended')
                                        <x-badge variant="success" size="sm">Hadir</x-badge>
                                    @elseif($reg->status === 'no_show')
                                        <x-badge variant="error" size="sm">No-Show</x-badge>
                                    @elseif($reg->status === 'pending_payment')
                                        <div class="flex items-center gap-2">
                                            <x-badge variant="warning" size="sm">Menunggu Bayar</x-badge>
                                            <form action="{{ route('organizer.events.confirm-payment', [$event, $reg]) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="px-2 py-1 text-[10px] font-semibold bg-success/10 text-success rounded-lg hover:bg-success hover:text-white transition-colors">Konfirmasi Bayar</button>
                                            </form>
                                        </div>
                                    @else
                                        <x-badge variant="neutral" size="sm">{{ ucfirst($reg->status) }}</x-badge>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-neutral-border">
                {{ $registrations->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-neutral-border p-12 text-center">
            <p class="text-sm text-neutral-muted">Belum ada pendaftar untuk event ini.</p>
        </div>
    @endif
</div>
@endsection
