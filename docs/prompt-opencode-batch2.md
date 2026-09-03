# Prompt OpenCode: Testimoni + Skeleton + Navbar

## TUGAS 4: TESTIMONI PARALLAX

File: resources/views/welcome.blade.php

Ganti section Apa Kata Mereka dengan parallax auto-scroll:
- Judul: Apa Kata Mereka?
- Sub: Testimoni dari member EventHub
- Container: overflow-x-auto, flex gap-6, snap-x snap-mandatory
- Auto-scroll: setInterval setiap 3 detik, scroll otomatis ke kanan
- Tombol prev/next: absolute positioned, visible on hover
- 10 komentar dummy (member saja):
  1. Rina Sari - Member - "EventHub memudahkan saya menemukan workshop desain di Bandung. Prosesnya simpel!" - 5 bintang
  2. Ahmad Fauzi - Member - "Saya sudah 5 kali daftar event lewat EventHub. Semuanya berjalan lancar." - 5 bintang
  3. Dewi Lestari - Member - "Suka dengan fitur favoritnya. Bisa simpan event menarik untuk nanti." - 4 bintang
  4. Budi Santoso - Member - "Dashboard-nya intuitif. Riwayat registrasi terlihat jelas." - 5 bintang
  5. Maya Putri - Member - "Event teknologi di Jakarta selalu saya temukan di EventHub." - 4 bintang
  6. Rizki Pratama - Member - "Proses registrasi cepat, tidak ribet. Langsung dapat konfirmasi." - 5 bintang
  7. Sari Dewi - Member - "Filter pencariannya sangat membantu. Bisa cari berdasarkan kota dan tema." - 4 bintang
  8. Andi Wijaya - Member - "Saya organiser sekaligus member. EventHub platform terbaik." - 5 bintang
  9. Lestari - Member - "Sering dapat info event baru lewat EventHub. Sangat update!" - 5 bintang
  10. Firmansyah - Member - "Rating bintang memudahkan pilih event. Terima kasih EventHub!" - 4 bintang

Setiap kartu: bg-white rounded-2xl p-6 shadow-sm min-w-[300px]
Isi: rating bintang (SVG), quote, nama, role

---

## TUGAS 5: SKELETON LOADING

File: resources/views/welcome.blade.php

Tambahkan skeleton loading di awal section (sebelum konten):
- Gunakan Alpine.js x-show dengan state loading
- Skeleton: bg-white rounded-2xl animate-pulse
- Warna skeleton: bg-primary-light/50 (ungu terang)
- Hilang setelah 1.5 detik (simulasi loading)

---

## TUGAS 6: NAVBAR

File: resources/views/components/navbar.blade.php

Perubahan:
1. Logo klik -> /about (bukan /)
2. Smooth scroll: tambah onclick="event.preventDefault(); document.querySelector(target).scrollIntoView({behavior:"smooth"})" untuk nav Beranda dan Kategori
3. Admin layout (layouts/admin.blade.php): tambah tombol Back di header
   <a href="javascript:history.back()" class="...">Back</a>
4. Organizer layout (layouts/organizer.blade.php): tambah tombol Back yang sama

---

Jalankan php artisan view:clear setelah selesai.