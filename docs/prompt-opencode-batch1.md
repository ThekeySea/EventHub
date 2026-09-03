# Prompt OpenCode: Footer + About Page + Event Teratas

## TUGAS 1: FOOTER

File: resources/views/components/footer.blade.php
Ganti SELURUH isi dengan footer 4 kolom berwarna bg-[#4338CA]:
- Kolom 1: Brand (logo E + EventHub + deskripsi + 3 icon socmed)
- Kolom 2: Explore (Semua Event + 5 kategori dari DB dynamic)
- Kolom 3: Akun (Masuk, Daftar, Dashboard, Profil)
- Kolom 4: EventHub (Tentang Kami /about, Bantuan, Privasi, Syarat)
Responsive: grid-cols-1 md:grid-cols-2 lg:grid-cols-4

## TUGAS 2: HALAMAN TENTANG KAMI

File baru: resources/views/about.blade.php
Gunakan <x-public-layout title="Tentang Kami - EventHub">

Isi:
1. Quote section: quote besar + nama penulis
   Quote: "EventHub hadir untuk menjembatani antara penyelenggara dan peserta."
   Nama: "Tim EventHub"

2. Grid 2 kartu (max-w-5xl mx-auto):
   Kartu Visi: bg-white rounded-2xl shadow-sm border p-8
   - Icon mata (eye SVG)
   - Judul: Visi
   - Isi: Menjadi platform event terbesar dan terpercaya di Indonesia

   Kartu Misi: bg-white rounded-2xl shadow-sm border p-8
   - Icon target (SVG)
   - Judul: Misi
   - Isi: Memudahkan penemuan event, menyediakan tools organizer, menjaga kualitas konten

3. Footer sudah otomatis dari layout

## TUGAS 3: EVENT TERATAS

File: resources/views/welcome.blade.php

Hapus section Event Pilihan + Paling Disuka.
Ganti dengan section Event Teratas:
- Judul: Event Teratas
- Sub: Event dengan antusiasme tertinggi
- 3 event dari $topEvents
- Badge ranking: badge("1") warna secondary/kuning, badge("2") abu, badge("3") abu
- Setiap event card pakai x-event-card component

HAPUS juga section Organizer Teraktif.

---

Jalankan php artisan view:clear setelah selesai.