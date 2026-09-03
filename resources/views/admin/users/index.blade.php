@extends('layouts.admin', ['activeNav' => 'users', 'pageTitle' => 'Manajemen Pengguna', 'breadcrumbs' => [['label' => 'Users']]])

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="w-full min-w-0 max-w-none space-y-6">
        <!-- Flash Messages -->
        @if(session('success'))
            <x-alert type="success" dismissible="true" class="mb-6">
                {{ session('success') }}
            </x-alert>
        @endif

        @if(session('error'))
            <x-alert type="error" dismissible="true" class="mb-6">
                {{ session('error') }}
            </x-alert>
        @endif

        <!-- Header Section -->
        <div class="w-full min-w-0 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins mb-1">
                    Manajemen Pengguna
                </h2>
                <p class="text-sm text-neutral-muted">
                    Kelola data, role akses (admin, organizer, member), dan status aktif seluruh pengguna EventHub.
                </p>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border p-4 sm:p-5 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-neutral-muted">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search', request('q')) }}"
                    placeholder="Cari nama atau email..." 
                    class="w-full pl-10 pr-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text placeholder:text-neutral-muted/60 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                />
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto justify-end">
                <!-- Role Filter -->
                <select 
                    name="role"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                >
                    <option value="">Semua Role</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="organizer" {{ request('role') === 'organizer' ? 'selected' : '' }}>Organizer</option>
                    <option value="member" {{ request('role') === 'member' ? 'selected' : '' }}>Member</option>
                </select>

                <!-- Status Filter -->
                <select 
                    name="is_active"
                    class="px-3.5 py-2 text-sm rounded-xl bg-white border border-neutral-border text-neutral-text focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all outline-none"
                >
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors">
                    Filter
                </button>

                @if(request('search') || request('q') || request('role') || request('is_active') !== null && request('is_active') !== '')
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-neutral-bg text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-border transition-colors">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Main Table Card -->
        <div class="w-full min-w-0 bg-white rounded-2xl border border-neutral-border shadow-sm overflow-hidden">
            <!-- Table Header Info -->
            <div class="px-6 py-4 border-b border-neutral-border/60 flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-neutral-muted">Daftar Pengguna</span>
                <span class="text-xs text-neutral-muted">{{ $users->total() }} {{ Str::plural('pengguna', $users->total()) }} ditemukan</span>
            </div>

            @if($users->count() > 0)
                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-bg/50 border-b border-neutral-border">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-text uppercase tracking-wider hidden md:table-cell">Terdaftar</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-text uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-neutral-border">
                            @foreach($users as $user)
                                <tr class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-primary-light text-primary font-bold flex items-center justify-center text-xs shrink-0 border border-primary/20">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="text-sm font-semibold text-neutral-text flex items-center gap-2">
                                                    <span>{{ $user->name }}</span>
                                                    @if($user->id === auth()->id())
                                                        <span class="text-[10px] font-medium px-2 py-0.5 rounded-full bg-primary-light text-primary">Anda</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-neutral-muted truncate">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role === 'admin')
                                            <x-badge variant="primary" size="sm">Admin</x-badge>
                                        @elseif($user->role === 'organizer')
                                            <x-badge variant="warning" size="sm">Organizer</x-badge>
                                        @else
                                            <x-badge variant="neutral" size="sm">Member</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_active)
                                            <x-badge variant="success" size="sm">Aktif</x-badge>
                                        @else
                                            <x-badge variant="error" size="sm">Nonaktif</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="text-xs text-neutral-muted">{{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a 
                                            href="{{ route('admin.users.edit', $user) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-neutral-bg hover:bg-primary-light text-neutral-text hover:text-primary text-xs font-semibold transition-colors"
                                        >
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            <span>Edit</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-neutral-border/60">
                        {{ $users->links() }}
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="py-16 px-6 text-center">
                    <div class="w-14 h-14 rounded-2xl bg-neutral-bg text-neutral-muted/60 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold font-poppins text-neutral-text mb-1">Pengguna Tidak Ditemukan</h3>
                    <p class="text-xs sm:text-sm text-neutral-muted max-w-sm mx-auto mb-4">
                        Tidak ada pengguna yang cocok dengan kriteria pencarian atau filter yang kamu masukkan.
                    </p>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white text-xs font-semibold rounded-xl hover:bg-primary-hover transition-colors">
                        Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
