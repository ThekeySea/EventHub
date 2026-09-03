<x-public-layout title="Tentang Kami - EventHub">
    <div class="py-16 sm:py-24 bg-neutral-bg">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-neutral-text font-poppins mb-6">Tentang EventHub</h1>
            <blockquote class="text-lg sm:text-xl font-medium text-neutral-muted italic mb-4">
                &ldquo;EventHub hadir untuk menjembatani antara penyelenggara dan peserta.&rdquo;
            </blockquote>
            <p class="text-sm font-semibold text-primary">&mdash; Tim EventHub</p>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Visi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-border p-8 flex flex-col items-start">
                    <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-neutral-text font-poppins mb-3">Visi</h2>
                    <p class="text-sm text-neutral-muted leading-relaxed">
                        Menjadi platform event terbesar dan terpercaya di Indonesia.
                    </p>
                </div>

                {{-- Misi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-border p-8 flex flex-col items-start">
                    <div class="w-12 h-12 rounded-xl bg-primary-light text-primary flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-neutral-text font-poppins mb-3">Misi</h2>
                    <p class="text-sm text-neutral-muted leading-relaxed">
                        Memudahkan penemuan event, menyediakan tools organizer, menjaga kualitas konten.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>