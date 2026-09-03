# Prompt: Cara Kerja EventHub - Two-Column Simple

## Untuk: OpenCode

File: resources/views/welcome.blade.php
Section LANGKAH-LANGKAH (baris 418-477).

## KONSEP

Dua kolom sederhana:
- KIRI: Daftar judul langkah (numbered list)
- KANAN: Deskripsi penjelasan langkah yang aktif

TIDAK ADA phone mockup, TIDAK ADA wireframe.
HANYA teks bersih dengan desain minimalis.

## STRUKTUR

      Cara Kerja EventHub
      4 langkah mudah

  (1) Buat Akun         +---------------------------+
                         |  Buat Akun                |
  (2) Temukan Event     |                           |
                         |  Daftar gratis dalam      |
  (3) Daftar Event      |  hitungan detik. Isi      |
                         |  nama, email, dan         |
  (4) Hadiri & Nikmati  |  password kamu.           |
                         +---------------------------+

Klik langkah lain -> kanan berubah.

## KODE

Ganti SELURUH section LANGKAH-LANGKAH dengan:

```html
{{-- LANGKAH-LANGKAH --}}
<section class="py-16 sm:py-20 lg:py-24 bg-neutral-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-neutral-text font-poppins">Cara Kerja EventHub</h2>
            <p class="text-sm text-neutral-muted mt-2">Mulai dalam 4 langkah mudah</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start" x-data="{ activeStep: 0 }">

            {{-- Kiri: Step Titles --}}
            <div class="space-y-2">
                @php($steps = [
                    ['title' => 'Buat Akun', 'desc' => 'Daftar gratis dalam hitungan detik. Isi nama, email, dan password kamu.'],
                    ['title' => 'Temukan Event', 'desc' => 'Jelajahi event berdasarkan tema, format, kota, dan minatmu.'],
                    ['title' => 'Daftar Event', 'desc' => 'Pilih event yang kamu suka, klik daftar, dan konfirmasi kehadiranmu.'],
                    ['title' => 'Hadiri & Nikmati', 'desc' => 'Datang ke event, dapatkan pengalaman baru, dan jejaring baru.'],
                ])
                @foreach($steps as $i => $step)
                    <button type="button" @click="activeStep = {{ $i }}"
                        class="w-full text-left px-5 py-4 rounded-xl transition-all duration-200 flex items-center gap-4"
                        :class="activeStep === {{ $i }} ? 'bg-white shadow-md border-l-4 border-primary' : 'hover:bg-white/50 border-l-4 border-transparent'">
                        <span class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-colors"
                            :class="activeStep === {{ $i }} ? 'bg-primary text-white' : 'bg-neutral-border text-neutral-muted'">
                            {{ $i + 1 }}
                        </span>
                        <h3 class="text-sm font-bold transition-colors"
                            :class="activeStep === {{ $i }} ? 'text-primary' : 'text-neutral-text'">
                                {{ $step["title"] }}
                        </h3>
                    </button>
                @endforeach
            </div>

            {{-- Kanan: Description --}}
            <div class="lg:pl-4">
                <div class="bg-white rounded-2xl shadow-sm border border-neutral-border p-6 sm:p-8 min-h-[240px] flex flex-col justify-center">
                    @foreach($steps as $i => $step)
                        <div x-show="activeStep === {{ $i }}" x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center text-sm font-bold">
                                    {{ $i + 1 }}
                                </span>
                                <h3 class="text-lg font-bold text-neutral-text font-poppins">{{ $step["title"] }}</h3>
                            </div>
                            <p class="text-sm text-neutral-muted leading-relaxed">{{ $step["desc"] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
```

## ATURAN
- JANGAN hapus section lain
- JANGAN tambah file baru
- TIDAK ADA phone mockup atau wireframe
- HANYA teks bersih: judul + deskripsi
- Alpine.js untuk switch langkah
- Layout 50/50 (lg:grid-cols-2)
- Responsive: mobile = kiri atas, kanan bawah

## TEST
1. php artisan view:clear
2. Buka localhost:8000 scroll ke Cara Kerja
3. Klik langkah -> kanan berubah deskripsi
4. Mobile: steps di atas, deskripsi di bawah
5. php artisan test -> semua hijau