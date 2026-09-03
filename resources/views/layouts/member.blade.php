@php
    $activeNav = $activeNav ?? 'dashboard';
    $pageTitle = $pageTitle ?? 'Member Dashboard';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-bg">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} — EventHub</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body 
    x-data="{ sidebarOpen: false, profileOpen: false }" 
    class="overflow-x-hidden bg-[#F8F9FC] font-sans antialiased text-neutral-text selection:bg-primary/20 selection:text-primary"
>
    <div class="min-h-dvh lg:flex">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
            class="fixed inset-0 bg-neutral-text/50 backdrop-blur-xs z-40 lg:hidden"></div>

        <!-- Mobile Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex h-dvh w-80 flex-col overflow-hidden border-r border-neutral-border bg-white shadow-lg transition-transform duration-300 lg:hidden">
            @include('member.partials.sidebar-content')
        </aside>

        <!-- Desktop Sidebar -->
        <aside class="hidden lg:sticky lg:top-0 lg:flex lg:h-dvh lg:w-72 lg:shrink-0 lg:flex-col lg:overflow-hidden lg:border-r lg:border-neutral-border lg:bg-white">
            @include('member.partials.sidebar-content')
        </aside>

        <!-- Main Content -->
        <div class="min-w-0 flex-1 flex flex-col">
            <!-- Topbar -->
            <header class="sticky top-0 z-30 h-16 bg-white border-b border-neutral-border px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4 shadow-xs">
                <div class="flex items-center gap-3 min-w-0">
                    <button @click="sidebarOpen = true" type="button"
                        class="lg:hidden p-2 rounded-xl text-neutral-muted hover:text-neutral-text hover:bg-neutral-bg ring-1 ring-neutral-border"
                        aria-label="Open sidebar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-lg font-bold text-neutral-text font-poppins truncate">{{ $pageTitle }}</h1>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-2 p-1 rounded-lg hover:bg-neutral-bg transition-colors">
                            <div class="w-8 h-8 rounded-lg bg-primary text-white font-bold text-xs flex items-center justify-center">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                            <span class="text-sm font-medium text-neutral-text hidden sm:block">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="profileOpen" x-cloak @click.away="profileOpen = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-neutral-border py-1.5 z-50 text-xs">
                            <a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Notifikasi @php($unreadCount = (auth()->user() ? auth()->user()->unreadNotificationsCount() : 0)) @if($unreadCount > 0)<span class="ml-1 px-1.5 py-0.5 text-[10px] font-bold bg-error text-white rounded-full">{{ $unreadCount }}</span>@endif</a>
                            <a href="{{ url('/') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Halaman Utama</a>
                            <a href="{{ route('member.dashboard') }}" class="block px-4 py-2 text-neutral-text hover:bg-neutral-bg transition-colors">Profil</a>
                            <div class="border-t border-neutral-border/60 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-error hover:bg-error-light transition-colors font-medium">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Content -->
            <main class="min-w-0 w-full overflow-x-hidden flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <div class="w-full min-w-0 space-y-6">
                    @yield('content')
                </div>
            </main>
            <!-- Footer -->
            <footer class="bg-white border-t border-neutral-border py-4 px-6 text-center text-xs text-neutral-muted">
                <p>&copy; {{ date('Y') }} EventHub. Hak cipta dilindungi.</p>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
