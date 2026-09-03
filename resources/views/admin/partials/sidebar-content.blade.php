<!-- Sidebar Top: Brand & Navigation -->
<div class="flex flex-col h-full overflow-hidden">
    <!-- Brand Header -->
    <div class="h-20 px-6 flex items-center justify-between border-b border-neutral-border/60 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-lg shadow-sm group-hover:scale-105 transition-transform duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <span class="font-poppins font-bold text-xl tracking-tight text-neutral-text">
                    Event<span class="text-primary">Hub</span>
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-neutral-muted">Admin Portal</span>
                </div>
            </div>
        </a>

        <!-- Mobile Close Button -->
        <button 
            @click="sidebarOpen = false" 
            type="button" 
            class="lg:hidden p-1.5 rounded-lg text-neutral-muted hover:bg-neutral-bg hover:text-neutral-text"
            aria-label="Close sidebar"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation Links List -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-8">
        <!-- Main Navigation Section -->
        <div>
            <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-muted/80 font-poppins">
                Main Menu
            </div>

            <nav class="space-y-1.5">
                <!-- 1. Dashboard -->
                <a 
                    href="{{ route('admin.dashboard') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'dashboard' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'dashboard' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Dashboard</span>
                    </div>
                    <span class="text-[10px] uppercase font-bold tracking-wider px-1.5 py-0.5 rounded {{ $activeNav === 'dashboard' ? 'bg-white/20 text-white' : 'text-neutral-muted bg-neutral-bg' }}">Live</span>
                </a>

                <!-- 2. Events -->
                <a 
                    href="{{ route('admin.events.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'events' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'events' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>Events</span>
                    </div>
                </a>

                <!-- 3. Registrations -->
                <a 
                    href="{{ route('admin.registrations.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'registrations' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'registrations' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Registrasi</span>
                    </div>
                </a>

                <!-- 3. Categories (Themes) -->
                <a 
                    href="{{ route('admin.categories.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'categories' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'categories' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span>Tema (Kategori)</span>
                    </div>
                </a>

                <!-- 4. Event Types (Jenis) -->
                <a 
                    href="{{ route('admin.event-types.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'event-types' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'event-types' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span>Jenis Acara</span>
                    </div>
                </a>

                <!-- 5. Cities (Kota) -->
                <a 
                    href="{{ route('admin.cities.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'cities' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'cities' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Kota / Lokasi</span>
                    </div>
                </a>

                <!-- 6. Analytics -->
                <a 
                    href="{{ route('admin.analytics') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'analytics' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'analytics' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Analytics</span>
                    </div>
                </a>

                <!-- 7b. Organizer Performance -->
                <a 
                    href="{{ route('admin.organizer-performance') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'organizer-performance' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'organizer-performance' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Kinerja Organizer</span>
                    </div>
                </a>

                <!-- 7. Users (Pengguna) -->
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'users' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'users' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Pengguna (Users)</span>
                    </div>
                </a>

                <!-- 8. Audit Log -->
                <a 
                    href="{{ route('admin.audit-logs.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'audit-logs' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'audit-logs' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                        <span>Audit Log</span>
                    </div>
                </a>

                <!-- 9. Reports -->
                <a 
                    href="{{ route('admin.reports.index') }}" 
                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'reports' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}"
                >
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $activeNav === 'reports' ? 'text-white' : 'text-neutral-muted' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>Laporan Event</span>
                    </div>
                </a>

            </nav>
        </div>

        <!-- System & Quick Links Section -->
        <div class="pt-4 border-t border-neutral-border/60">
            <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-muted/80 font-poppins">
                Shortcuts
            </div>
            <div class="space-y-1">
                <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2 rounded-xl text-xs font-medium text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg transition-colors">
                    <span class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <span>View Public Site</span>
                    </span>
                    <span class="text-[10px] text-neutral-muted">↗</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Sidebar Footer: Admin User Badge -->
    <div class="p-4 border-t border-neutral-border/80 bg-neutral-bg/40 shrink-0">
        <div class="flex items-center justify-between p-2 rounded-xl bg-white border border-neutral-border shadow-xs">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-xl bg-primary-light text-primary font-bold flex items-center justify-center text-sm shrink-0 border border-primary/20">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 2)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold text-neutral-text truncate">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[11px] text-neutral-muted truncate capitalize">{{ auth()->user()->role ?? 'admin' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" title="Logout" class="p-2 text-neutral-muted hover:text-error hover:bg-error-light rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
