<x-public-layout title="Halaman Tidak Ditemukan - EventHub">
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="max-w-md text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-warning-light text-warning flex items-center justify-center">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-neutral-text font-poppins mb-3">404</h1>
            <h2 class="text-xl font-semibold text-neutral-text font-poppins mb-2">Halaman Tidak Ditemukan</h2>
            <p class="text-sm text-neutral-muted mb-8">Halaman yang Anda cari tidak tersedia atau telah dipindahkan.</p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors shadow-sm">
                    Kembali ke Beranda
                </a>
                <a href="{{ route('events.index') }}" class="px-6 py-3 border border-neutral-border text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-bg transition-colors">
                    Explore Events
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
