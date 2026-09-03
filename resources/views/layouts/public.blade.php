<x-app-layout :title="$title ?? null">
    <div class="min-h-screen flex flex-col">
        <!-- Single Header / Navigation -->
        @if(isset($navbar))
            {{ $navbar }}
        @else
            <x-navbar />
        @endif

        <!-- Main Public Content Container -->
        <main class="flex-grow">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Footer (Footer Component) -->
        @if(isset($footer))
            {{ $footer }}
        @else
            <x-footer />
        @endif


    </div>
</x-app-layout>
