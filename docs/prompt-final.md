# Prompt Final: Sisa Perubahan EventHub

## PROJECT: EventHub (Laravel Blade)

---

## TUGAS 1: SKELETON LOADING HOMEPAGE

File: resources/views/welcome.blade.php

Tambahkan skeleton loading di awal halaman:
- Alpine.js x-data loading: true, setTimeout 1.5s
- x-show loading, x-cloak
- Skeleton: animate-pulse, bg-primary-light/50
- 3-4 skeleton bars + circles

---

## TUGAS 2: CARA KERJA 2 KOLOM

File: resources/views/welcome.blade.php
Section Cara Kerja EventHub

Ganti section menjadi 2 kolom:
- KIRI: 4 tombol numbered list (Alpine.js)
- KANAN: Card putih berisi judul + deskripsi langkah aktif
- Layout: grid-cols-1 lg:grid-cols-2
- TIDAK ADA phone mockup

---

## TUGAS 3: FILTER MODAL MOBILE

File: resources/views/welcome.blade.php

Pada section search bar:
- Mobile: 3 tombol Tema/Format/Kota horizontal + modal popup
- Desktop: tetap select dropdown
- Modal: fixed inset-0, backdrop, radio button
- Alpine.js state management

---

## VERIFIKASI
php artisan view:clear && php artisan test