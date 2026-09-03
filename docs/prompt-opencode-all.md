# Prompt OpenCode — Semua Perubahan View EventHub

## PROJECT: EventHub (Laravel Blade)

---

## RINGKASAN PERUBAHAN

1. Footer: warna bg-[#4338CA], 4 kolom, responsive
2. Navbar: logo -> /about, smooth scroll, back button admin/organizer
3. Halaman Tentang Kami: /about (quote + visi/misi)
4. Event Teratas: gabung 2 section jadi 1, badge ranking
5. Hapus section Organizer Teraktif
6. Testimoni: parallax auto+manual, 10 komentar
7. Skeleton Loading: homepage

---

## PROMPT 1: FOOTER

File: resources/views/components/footer.blade.php
Ganti SELURUH isi dengan footer 4 kolom:
- Brand (logo + deskripsi + socmed)
- Explore (Semua Event + 5 kategori dynamic dari DB)
- Akun (Masuk, Daftar, Dashboard, Profil)
- EventHub (Tentang Kami, Bantuan, Privasi, Syarat)
Warna: bg-[#4338CA], responsive grid 1/2/4 kolom

---

## PROMPT 2: HALAMAN TENTANG KAMI

File baru: resources/views/about.blade.php
Gunakan <x-public-layout>
Isi: quote section + grid 2 kartu (Visi & Misi) + footer

---

## PROMPT 3: EVENT TERATAS

File: resources/views/welcome.blade.php
Hapus section Event Pilihan + Paling Disuka.
Ganti dengan section Event Teratas (3 event, badge ranking 1/2/3).
Gunakan variable $topEvents dari controller.

---

## PROMPT 4: HAPUS ORGANIZER TERAKTIF

File: resources/views/welcome.blade.php
Hapus section Organizer Teraktif (parallax organizer).

---

## PROMPT 5: TESTIMONI PARALLAX

File: resources/views/welcome.blade.php
Ganti section Apa Kata Mereka dengan parallax auto-scroll.
10 komentar dummy member, rating bintang, auto + manual scroll.

---

## PROMPT 6: SKELETON LOADING

File: resources/views/welcome.blade.php
Tambahkan skeleton loading (purple) sebelum konten dimuat.

---

## PROMPT 7: NAVBAR

File: resources/views/components/navbar.blade.php
- Logo klik -> /about
- Smooth scroll untuk Beranda dan Kategori
- Admin/organizer layout: tambah tombol Back (browser history)

---

## urutan eksekusi
1. Footer dulu
2. About page
3. Event Teratas + Hapus Organizer
4. Testimoni parallax
5. Skeleton loading
6. Navbar

Jalankan php artisan view:clear setelah semua selesai.