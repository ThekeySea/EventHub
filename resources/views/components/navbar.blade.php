<!-- Desktop Navbar -->
<header class="hidden md:block fixed top-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-b border-neutral-border shadow-sm" x-data="{ profileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex items-center gap-10">
                <a href="{{ url('/about') }}" class="flex items-center gap-2.5 shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-base shadow-sm">E</div>
                    <span class="text-xl font-bold text-neutral-text font-poppins">Event<span class="text-primary">Hub</span></span>
                </a>
                <nav class="flex items-center gap-1">
                    <a href="{{ url('/') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('home') ? 'text-primary bg-primary-light' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }} transition-all duration-200">Beranda</a>
                    <a href="{{ url('/events') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('events.*') ? 'text-primary bg-primary-light' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }} transition-all duration-200">Jelajahi</a>
                    <a href="{{ route('categories.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('categories.*') ? 'text-primary bg-primary-light' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }} transition-all duration-200">Kategori</a>
                    <a href="{{ url('/about') }}" class="px-4 py-2.5 rounded-xl text-sm font-semibold {{ request()->routeIs('about') ? 'text-primary bg-primary-light' : 'text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg' }} transition-all duration-200">Tentang</a>
                </nav>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('notifications.index') }}" class="relative p-2.5 rounded-xl text-neutral-muted hover:text-primary hover:bg-neutral-bg transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(auth()->user()->unreadNotificationsCount() > 0)<span class="absolute -top-0.5 -right-0.5 w-5 h-5 rounded-full bg-error text-white text-[10px] font-bold flex items-center justify-center">{{ auth()->user()->unreadNotificationsCount() }}</span>@endif
                    </a>
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-neutral-bg transition-all duration-200 focus:outline-none">
                            <div class="w-9 h-9 rounded-xl bg-primary text-white font-bold text-xs flex items-center justify-center shadow-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                            <span class="text-sm font-semibold text-neutral-text hidden lg:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-neutral-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="profileOpen" x-cloak @click.away="profileOpen = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-neutral-border py-1.5 z-50">
                            <div class="px-4 py-3 border-b border-neutral-border/60"><p class="text-sm font-bold text-neutral-text">{{ auth()->user()->name }}</p><p class="text-xs text-neutral-muted truncate">{{ auth()->user()->email }}</p></div>
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 text-sm text-neutral-text hover:bg-neutral-bg transition-colors">Admin Dashboard</a>
                            @elseif(auth()->user()->role === 'organizer')
                                <a href="{{ route('organizer.dashboard') }}" class="block px-4 py-2.5 text-sm text-neutral-text hover:bg-neutral-bg transition-colors">Organizer Dashboard</a>
                            @else
                                <a href="{{ route('member.dashboard') }}" class="block px-4 py-2.5 text-sm text-neutral-text hover:bg-neutral-bg transition-colors">Profil</a>
                            @endif
                            <div class="border-t border-neutral-border/60 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-error hover:bg-error-light transition-colors font-medium">Keluar</button></form>
                        </div>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="px-5 py-2.5 text-sm font-semibold text-neutral-text hover:text-primary rounded-xl hover:bg-neutral-bg transition-all duration-200">Masuk</a>
                    <a href="{{ url('/register') }}" class="px-5 py-2.5 text-sm font-semibold bg-primary text-white rounded-xl hover:bg-primary-hover transition-all duration-200 shadow-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</header>


<!-- Mobile Bottom Navbar -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-neutral-border shadow-[0_-2px_10px_rgba(0,0,0,0.05)]">
    <div class="grid grid-cols-5 gap-0 px-1 py-1">
        <a href="{{ url('/') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('home') ? 'text-primary' : 'text-neutral-muted' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[10px] font-semibold mt-0.5">Beranda</span>
        </a>
        <a href="{{ url('/events') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('events.*') ? 'text-primary' : 'text-neutral-muted' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span class="text-[10px] font-semibold mt-0.5">Jelajahi</span>
        </a>
        <a href="{{ route('categories.index') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'text-primary' : 'text-neutral-muted' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            <span class="text-[10px] font-semibold mt-0.5">Kategori</span>
        </a>
        @auth
            <a href="{{ route('member.dashboard') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('member.*') ? 'text-primary' : 'text-neutral-muted' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="text-[10px] font-semibold mt-0.5">Dashboard</span>
            </a>
            <a href="{{ url('/about') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('about') ? 'text-primary' : 'text-neutral-muted' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-semibold mt-0.5">Tentang</span>
            </a>
        @else
            <a href="{{ url('/login') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 text-neutral-muted">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span class="text-[10px] font-semibold mt-0.5">Masuk</span>
            </a>
            <a href="{{ url('/about') }}" class="flex flex-col items-center justify-center py-2 rounded-xl transition-all duration-200 {{ request()->routeIs('about') ? 'text-primary' : 'text-neutral-muted' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-[10px] font-semibold mt-0.5">Tentang</span>
            </a>
        @endauth
    </div>
</nav>
