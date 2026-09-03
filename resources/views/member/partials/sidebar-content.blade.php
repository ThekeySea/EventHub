<div class="flex flex-col h-full overflow-hidden">
    <!-- Brand Header -->
    <div class="h-16 px-6 flex items-center justify-between border-b border-neutral-border/60 shrink-0">
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
            <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">E</div>
            <span class="font-poppins font-bold text-lg tracking-tight text-neutral-text">Event<span class="text-primary">Hub</span></span>
        </a>
        <button @click="sidebarOpen = false" type="button" class="lg:hidden p-1.5 rounded-lg text-neutral-muted hover:bg-neutral-bg hover:text-neutral-text" aria-label="Close sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6">
        <div>
            <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-muted/80 font-poppins">Menu</div>
            <nav class="space-y-1.5">
                <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'dashboard' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('member.registrations') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'registrations' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Registrasi Saya</span>
                </a>
                <a href="{{ route('member.favorites') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'favorites' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Favorit Saya</span>
                </a>
                <a href="{{ route('member.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'profile' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil</span>
                </a>
                <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'notifications' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span>Notifikasi</span>
                </a>
            </nav>
        </div>

        <div>
            <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-muted/80 font-poppins">Jelajahi</div>
            <nav class="space-y-1.5">
                <a href="{{ url('/') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('events.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Explore Events</span>
                </a>
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg transition-all duration-150">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>Kategori</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-4 border-t border-neutral-border/60 shrink-0">
        <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-neutral-bg/50">
            <div class="w-9 h-9 rounded-xl bg-primary text-white font-bold text-xs flex items-center justify-center">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
            <div class="flex-1 min-w-0">
                <p class="text-xs font-semibold text-neutral-text truncate">{{ auth()->user()->name }}</p>
                <p class="text-[10px] text-neutral-muted truncate">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</div>
