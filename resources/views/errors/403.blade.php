<x-public-layout title="Akses Ditolak - EventHub">
    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="max-w-md text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-error-light text-error flex items-center justify-center">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-6V9a4 4 0 00-8 0v2"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-neutral-text font-poppins mb-3">403</h1>
            <h2 class="text-xl font-semibold text-neutral-text font-poppins mb-2">Akses Ditolak</h2>
            <p class="text-sm text-neutral-muted mb-8">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <div class="flex items-center justify-center gap-3">
                <a href="{{ url('/') }}" class="px-6 py-3 bg-primary text-white text-sm font-semibold rounded-xl hover:bg-primary-hover transition-colors shadow-sm">
                    Kembali ke Beranda
                </a>
                <button onclick="history.back()" class="px-6 py-3 border border-neutral-border text-neutral-text text-sm font-semibold rounded-xl hover:bg-neutral-bg transition-colors">
                    Halaman Sebelumnya
                </button>
            </div>
        </div>
    </div>
</x-public-layout>
