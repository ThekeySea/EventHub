@php
    $activeNav = $activeNav ?? 'dashboard';
    $pageTitle = $pageTitle ?? 'Admin Dashboard';
    $breadcrumbs = $breadcrumbs ?? [];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') — EventHub</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Fonts: Poppins (Design.md Token) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body 
    x-data="{ 
        sidebarOpen: false, 
        profileDropdownOpen: false,
        notificationOpen: false,
        activeMenu: '{{ $activeNav }}'
    }" 
    class="overflow-x-hidden bg-[#F8F9FC] font-sans antialiased text-neutral-text selection:bg-primary/20 selection:text-primary"
>
    <!-- Root Admin Container -->
    <div class="min-h-dvh lg:flex">

        <!-- Mobile Sidebar Backdrop -->
        <div 
            x-show="sidebarOpen" 
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-neutral-text/50 backdrop-blur-xs z-40 lg:hidden"
            aria-hidden="true"
        ></div>

        <!-- Mobile Sidebar Off-canvas Drawer -->
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex h-dvh w-80 flex-col overflow-hidden border-r border-neutral-border bg-white shadow-lg transition-transform duration-300 lg:hidden"
        >
            @include('admin.partials.sidebar-content')
        </aside>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:sticky lg:top-0 lg:flex lg:h-dvh lg:w-80 lg:shrink-0 lg:flex-col lg:overflow-hidden lg:border-r lg:border-neutral-border lg:bg-white">
            @include('admin.partials.sidebar-content')
        </aside>

        <!-- Main Content Wrapper -->
        <div class="min-w-0 flex-1">

            <!-- TOPBAR -->
            <header class="sticky top-0 z-30 h-20 bg-white border-b border-neutral-border px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 shadow-xs">
                <!-- Left: Mobile Menu Trigger & Page Context -->
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <!-- Back Button -->
                    <button 
                        onclick="history.back()" 
                        type="button" 
                        class="p-2 rounded-xl text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg focus:outline-none ring-1 ring-neutral-border transition-colors"
                        title="Kembali"
                        aria-label="Kembali ke halaman sebelumnya"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </button>

                    <button 
                        @click="sidebarOpen = true" 
                        type="button" 
                        class="lg:hidden p-2 rounded-xl text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg focus:outline-none ring-1 ring-neutral-border"
                        aria-label="Open sidebar"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Breadcrumbs & Heading Info -->
                    <div class="min-w-0">
                        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                            <nav class="hidden sm:flex items-center gap-1.5 text-xs text-neutral-muted mb-0.5" aria-label="Breadcrumb">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition-colors">Admin</a>
                                @foreach($breadcrumbs as $crumb)
                                    <span class="text-neutral-border">/</span>
                                    @if(isset($crumb['url']) && !$loop->last)
                                        <a href="{{ $crumb['url'] }}" class="hover:text-primary transition-colors">{{ $crumb['label'] }}</a>
                                    @else
                                        <span class="font-medium text-neutral-text truncate">{{ $crumb['label'] }}</span>
                                    @endif
                                @endforeach
                            </nav>
                        @endif
                        <h1 class="text-lg sm:text-xl font-bold text-neutral-text font-poppins tracking-tight truncate">
                            {{ $pageTitle }}
                        </h1>
                    </div>
                </div>

                <!-- Right: Notifications, User -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Notification Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            type="button" 
                            class="p-2.5 rounded-xl text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg relative transition-colors focus:outline-none"
                            aria-label="Notifications"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-error ring-2 ring-white"></span>
                        </button>

                        <!-- Notification Dropdown Menu -->
                        <div 
                            x-show="open" 
                            x-cloak
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-lg border border-neutral-border py-2 z-50"
                        >
                            <div class="px-4 py-2 border-b border-neutral-border/60 flex items-center justify-between">
                                <span class="font-semibold text-xs text-neutral-text">Notifikasi</span>
                                @php($unreadCount = (auth()->user() ? auth()->user()->unreadNotificationsCount() : 0))
                                @if($unreadCount > 0)
                                    <span class="text-[10px] text-primary font-medium">{{ $unreadCount }} belum dibaca</span>
                                @endif
                            </div>
                            <div class="divide-y divide-neutral-border/50 text-xs max-h-64 overflow-y-auto">
                                @php($adminNotifs = auth()->user()->notifications()->latest()->limit(5)->get())
                                @forelse($adminNotifs as $notif)
                                    <a href="{{ $notif->action_url ?? '#' }}" class="block p-3 hover:bg-neutral-bg transition-colors">
                                        <p class="font-medium text-neutral-text">{{ $notif->title }}</p>
                                        <p class="text-neutral-muted text-[11px] mt-0.5 line-clamp-1">{{ $notif->message }}</p>
                                        <span class="text-[10px] text-neutral-muted">{{ $notif->created_at->diffForHumans() }}</span>
                                    </a>
                                @empty
                                    <div class="p-4 text-center text-neutral-muted">
                                        <p>Tidak ada notifikasi</p>
                                    </div>
                                @endforelse
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-center text-xs font-semibold text-primary hover:bg-neutral-bg transition-colors border-t border-neutral-border/60">Lihat Semua Notifikasi</a>
                        </div>
                    </div>

                    <!-- Profile Quick Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            @click="open = !open" 
                            type="button" 
                            class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-neutral-bg transition-colors focus:outline-none"
                        >
                            <div class="w-9 h-9 rounded-xl bg-primary text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-xs font-semibold text-neutral-text leading-tight">{{ auth()->user()->name ?? 'Admin User' }}</p>
                                <p class="text-[10px] text-neutral-muted leading-tight capitalize">{{ auth()->user()->role ?? 'admin' }}</p>
                            </div>
                            <svg class="w-4 h-4 text-neutral-muted hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div 
                            x-show="open" 
                            x-cloak
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-lg border border-neutral-border py-1.5 z-50 text-xs"
                        >
                            <div class="px-4 py-2 border-b border-neutral-border/60">
                                <p class="font-semibold text-neutral-text">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-[11px] text-neutral-muted truncate">{{ auth()->user()->email ?? 'admin@eventhub.test' }}</p>
                            </div>
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Notifikasi @php($unreadCount = (auth()->user() ? auth()->user()->unreadNotificationsCount() : 0)) @if($unreadCount > 0)<span class="ml-1 px-1.5 py-0.5 text-[10px] font-bold bg-error text-white rounded-full">{{ $unreadCount }}</span>@endif</a>
                            <a href="{{ url('/') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Halaman Utama</a>
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Admin Dashboard</a>
                            <div class="border-t border-neutral-border/60 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-error hover:bg-error-light transition-colors font-medium">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>                    <!-- MAIN SCROLLABLE CONTENT BODY -->
            <main class="min-w-0 w-full overflow-x-hidden px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <div class="w-full min-w-0 space-y-6">
                    @yield('content')
                </div>
            </main>

            <!-- Admin Footer -->
            <footer class="bg-white border-t border-neutral-border py-4 px-6 text-center text-xs text-neutral-muted">
                <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p>&copy; {{ date('Y') }} EventHub Platform. Hak cipta dilindungi.</p>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
