<!-- Sidebar Top: Brand & Navigation -->
<div class="flex flex-col h-full overflow-hidden">
    <!-- Brand Header -->
    <div class="h-20 px-6 flex items-center justify-between border-b border-neutral-border/60 shrink-0">
        <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 group">
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
                    <span class="text-[11px] font-semibold uppercase tracking-wider text-neutral-muted">Organizer Portal</span>
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
        <div>
            <div class="px-3 mb-2 text-[11px] font-semibold uppercase tracking-wider text-neutral-muted/80 font-poppins">
                Menu
            </div>
            <nav class="space-y-1.5">
                <a href="{{ route('organizer.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'dashboard' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="/organizer/events" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'events' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Event Saya</span>
                </a>
                <a href="/organizer/events/create" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-150 {{ $activeNav === 'create' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Buat Event</span>
                </a>
            </nav>
        </div>
    </div>
</div>
