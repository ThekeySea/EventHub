# Prompt: Mobile Filter Modal

## Untuk: OpenCode

---

## KONTEKS

File: `resources/views/welcome.blade.php`

Bagian search/filter ada di baris 28-62. Saat ini ada 3 `<select>` dropdown:
- `name="category"` â€” placeholder "Semua Tema"
- `name="format"` â€” placeholder "Semua Format"
- `name="city"` â€” placeholder "Semua Kota"

Di mobile, ketiga dropdown ini muncul **vertikal** (stacked) dan memakan banyak tempat.

---

## YANG INGIN DICAPAI

Pada **mobile** (di bawah breakpoint `sm` / `< 640px`):
1. Ganti 3 dropdown menjadi **3 tombol compact** dalam 1 baris horizontal (`grid grid-cols-3`)
2. Tulisan tombol hanya: **"Tema"**, **"Format"**, **"Kota"** (tanpa kata "Semua")
3. Setiap tombol jika diklik membuka **modal popup** (bukan dropdown!)
4. Modal berisi daftar opsi + "Semua" di atas, dengan backdrop gelap
5. Pilih opsi -> modal tutup -> tombol berubah nama & warna

Pada **desktop** (`sm:` / `>= 640px`):
- **Tetap pertahankan** tampilan `<select>` dropdown seperti sekarang

---

## STRUKTUR YANG DIINGINKAN (MOBILE)

```
[ Cari event, lokasi atau tema...    ] [ Cari Event ]
[   Tema   ] [  Format  ] [   Kota   ]      <- 3 tombol horizontal
```

Klik "Tema" -> muncul modal:
```
+----------------------------------+
|  [X]   Pilih Tema               |
|----------------------------------|
|  (o) Semua                       |
|  ( ) Technology                  |
|  ( ) Music                       |
|  ( ) Education                   |
|  ( ) Sport                       |
|  ( ) Business                    |
|  ( ) Art                         |
|  ( ) Community                   |
|  ( ) Competition                 |
+----------------------------------+
```

Pilih opsi -> modal tutup -> tombol berubah jadi "Music" dengan warna primary.

---

## CARA IMPLEMENTASI

### Langkah 1: Tambah x-data ke form

Ganti `<form>` yang ada â€” tambahkan x-data untuk state modal:
```html
<form action="{{ route('events.index') }}" method="GET"
  x-data="{
    showModal: null,
    selectedCategory: '',
    selectedFormat: '',
    selectedCity: ''
  }"
  class="bg-white rounded-2xl shadow-2xl p-4 sm:p-5">
```

### Langkah 2: Tambahkan mobile buttons + modals

Tambahkan block ini SETELAH search input + tombol Cari, SEBELUM div yang berisi select.

```html
{{-- Mobile Filter Buttons + Modals --}}
<div class="grid grid-cols-3 gap-2 sm:hidden mt-1">

    {{-- Tombol Tema --}}
    <button type="button" @click="showModal = 'category'"
        class="px-3 py-2.5 rounded-xl text-xs font-semibold border transition-all text-center truncate"
        :class="selectedCategory ? 'bg-primary-light text-primary border-primary/30' : 'bg-neutral-bg text-neutral-muted border-neutral-border'">
        <span x-text="selectedCategory || 'Tema'"></span>
    </button>

    {{-- Tombol Format --}}
    <button type="button" @click="showModal = 'format'"
        class="px-3 py-2.5 rounded-xl text-xs font-semibold border transition-all text-center truncate"
        :class="selectedFormat ? 'bg-primary-light text-primary border-primary/30' : 'bg-neutral-bg text-neutral-muted border-neutral-border'">
        <span x-text="selectedFormat || 'Format'"></span>
    </button>

    {{-- Tombol Kota --}}
    <button type="button" @click="showModal = 'city'"
        class="px-3 py-2.5 rounded-xl text-xs font-semibold border transition-all text-center truncate"
        :class="selectedCity ? 'bg-primary-light text-primary border-primary/30' : 'bg-neutral-bg text-neutral-muted border-neutral-border'">
        <span x-text="selectedCity || 'Kota'"></span>
    </button>
</div>

{{-- Modal: Pilih Tema --}}
<div x-show="showModal === 'category'" x-cloak
    class="fixed inset-0 z-50 flex items-end sm:items-center justify-center p-0 sm:p-4"
    style="display: none;">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = null"></div>
    {{-- Content --}}
    <div class="relative bg-white w-full sm:max-w-md sm:rounded-2xl rounded-t-2xl max-h-[80vh] flex flex-col shadow-2xl"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-neutral-border">
            <h3 class="text-base font-bold text-neutral-text font-poppins">Pilih Tema</h3>
            <button type="button" @click="showModal = null" class="w-8 h-8 rounded-full bg-neutral-bg flex items-center justify-center text-neutral-muted hover:text-neutral-text transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        {{-- Options --}}
        <div class="overflow-y-auto flex-1 p-2">
            <button type="button" @click="selectedCategory = ''; showModal = null"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors"
                :class="selectedCategory === '' ? 'bg-primary-light text-primary font-semibold' : 'text-neutral-text hover:bg-neutral-bg'">
                <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                    :class="selectedCategory === '' ? 'border-primary' : 'border-neutral-border'">
                    <span x-show="selectedCategory === ''" class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                </span>
                Semua
            </button>
            @foreach($themes as $theme)
            <button type="button" @click="selectedCategory = '{{ $theme->name }}'; showModal = null"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition-colors"
                :class="selectedCategory === '{{ $theme->name }}' ? 'bg-primary-light text-primary font-semibold' : 'text-neutral-text hover:bg-neutral-bg'">
                <span class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                    :class="selectedCategory === '{{ $theme->name }}' ? 'border-primary' : 'border-neutral-border'">
                    <span x-show="selectedCategory === '{{ $theme->name }}'" class="w-2.5 h-2.5 rounded-full bg-primary"></span>
                </span>
                {{ $theme->name }}
            </button>
            @endforeach
        </div>
    </div>
</div>

{{-- Modal: Pilih Format â€” pola sama, ganti category->format, themes->formats --}}
{{-- Modal: Pilih Kota â€” pola sama, ganti category->city, themes->cities --}}
```

**PENTING:** copy modal block di atas dan buat 2 duplikat lagi untuk Format dan Kota.
Ganti:
- `showModal === 'category'` -> `showModal === 'format'` / `'city'`
- `selectedCategory` -> `selectedFormat` / `selectedCity`
- `Pilih Tema` -> `Pilih Format` / `Pilih Kota`
- `@foreach($themes as $theme)` -> `@foreach($formats as $format)` / `@foreach($cities as $city)`

### Langkah 3: Sembunyikan select di mobile

Ganti `flex flex-col sm:flex-row gap-3` menjadi `hidden sm:flex gap-3`

### Langkah 4: Hidden inputs untuk mobile

SEBELUM `</form>`, tambahkan:
```html
<input type="hidden" name="category" :value="selectedCategory">
<input type="hidden" name="format" :value="selectedFormat">
<input type="hidden" name="city" :value="selectedCity">
```

### Langkah 5: x-cloak CSS

Di `resources/css/app.css`, tambahkan: `[x-cloak] { display: none !important; }`

- **JANGAN** ubah atribut `name` (`category`, `format`, `city`)
- **JANGAN** ubah logika form action atau method
- **JANGAN** menambah file baru — kerjakan di `welcome.blade.php` saja
- Gunakan **modal** (bukan dropdown!) untuk mobile
- Modal muncul dari bawah (`items-end`) di mobile, tengah di desktop
- Backdrop: `bg-black/50 backdrop-blur-sm`, klik backdrop = tutup modal
- Tombol close (X) di header modal
- Opsi pakai radio button style (lingkaran) — yang dipilih berwarna primary
- Yang dipilih: `bg-primary-light text-primary font-semibold`
- Label tombol: "Tema", "Format", "Kota" (TANPA "Semua")
- Opsi "Semua" tetap ada sebagai item pertama di modal

---

## TEST CHECKLIST

1. `php artisan view:clear`
2. Buka `localhost:8000` di Chrome DevTools mobile (375px)
3. Pastikan 3 tombol horizontal di bawah search bar
4. Klik "Tema" -> modal muncul dari bawah dengan backdrop gelap
5. Pilih "Music" -> modal tutup -> tombol jadi "Music" warna primary
6. Klik "Cari Event" -> redirect ke `/events?category=Music`
7. Klik backdrop atau X -> modal tutup
8. Desktop (>=640px) -> dropdown select seperti biasa
9. `php artisan test` -> semua hijau