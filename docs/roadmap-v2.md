# 🗺️ Roadmap EventHub v2 — Post-Tahap 6

## Status Saat Ini (Agustus 2026)

### ✅ Selesai (Tahap 1-6)
- Fortify auth + role middleware
- Admin: Dashboard (data nyata + moderation), Categories CRUD, Event Types CRUD, Cities CRUD, Events moderation (approve/reject)
- Organizer: Dashboard, Event CRUD (create/edit/draft/submit), Form dengan 5 dimensi kategori
- Public: Homepage, Explore /events dengan filter 4 dimensi
- Database: 3 tabel referensi (event_types, event_formats, cities) + FK di events
- Seeder lengkap + test suite hijau (34 tests)

---

## Tahap 7 — Event Detail Publik
**FR:** FR-02.3, FR-04

Yang Dikerjakan:
1. Route GET /events/{slug} → PublicEventController::show()
2. Scope: hanya event published + end_at >= now()
3. View: judul, banner, deskripsi, kategori, organizer, tanggal/waktu, lokasi/online_url, kapasitas, slot tersisa, tombol daftar (perlu login), tombol favorite
4. Hitung registrations_count untuk slot tersisa
5. Indikasi: event penuh, registrasi ditutup, event sudah berlalu
6. SEO: title tag dinamis, meta description

Definisi Selesai: Guest bisa buka /events/{slug} dan lihat semua info event published.

---

## Tahap 8 — Registrasi Event
**FR:** FR-06

Yang Dikerjakan:
1. Route POST /events/{event}/register (auth required)
2. Validasi: event published, belum penuh, belum didaftari, registrasi belum ditutup, event belum berlalu
3. Buat record event_registrations (status: registered, registered_at: now())
4. Redirect back dengan flash success
5. Route DELETE /my-registrations/{registration} untuk pembatalan
6. Pembatalan hanya bisa sebelum start_at
7. Organizer bisa lihat pendaftar: GET /organizer/events/{event}/registrations

Definisi Selesai: Member bisa daftar event, cek duplikat/kapasitas, batalkan. Organizer lihat daftar pendaftar.

---

## Tahap 9 — Favorites
**FR:** FR-05

Yang Dikerjakan:
1. Route POST /events/{event}/favorite (auth required, toggle)
2. Unique constraint (user_id, event_id) sudah ada
3. Route DELETE /events/{event}/favorite untuk hapus
4. Tombol favorite di halaman detail event (Alpine.js toggle)
5. Route GET /favorites → daftar favorit user dengan event cards

Definisi Selesai: Member bisa tambah/hapus favorit, lihat daftar favorit.

---

## Tahap 10 — Member Dashboard Lengkap
**FR:** FR-07

Yang Dikerjakan:
1. Dashboard member: ringkasan jumlah registrasi aktif + favorit
2. Daftar event yang akan diikuti (upcoming registrations)
3. Riwayat registrasi (registered, cancelled, attended)
4. Halaman /my-registrations dengan filter status
5. Halaman /favorites (dari Tahap 9)

Definisi Selesai: Dashboard member menampilkan data registrasi & favorit yang berguna.

---

## Tahap 11 — Profil Pengguna
**FR:** FR-01.6

Yang Dikerjakan:
1. Route GET /profile → form edit profil
2. Route PATCH /profile → update nama, email, telepon, avatar (upload)
3. Route GET /profile/password → form ganti password
4. Route PUT /profile/password → update password
5. Validasi: email unik, foto max 2MB, tipe gambar

Definisi Selesai: Semua user bisa update profil dan ganti password.

---

## Tahap 12 — Organizer: Cancel Event + Lihat Pendaftar
**FR:** FR-08.7, FR-08.8, FR-06.7

Yang Dikerjakan:
1. Route POST /organizer/events/{event}/cancel → status jadi cancelled
2. Hanya dari status draft atau pending
3. Route GET /organizer/events/{event}/registrations → daftar pendaftar
4. Tabel pendaftar: nama, email, waktu daftar, status registrasi

Definisi Selesai: Organizer bisa batalkan event draft/pending, lihat daftar pendaftar.

---

## Tahap 13 — Admin: Kelola Pengguna
**FR:** FR-09.4

Yang Dikerjakan:
1. Route GET /admin/users → daftar semua user
2. Search + filter by role, status
3. Route PATCH /admin/users/{user} → update role, status
4. Admin tidak bisa menonaktifkan diri sendiri

Definisi Selesai: Admin bisa lihat, cari, dan kelola semua user.

---

## Tahap 14 — Public: Halaman Kategori
**FR:** FR-02.5

Yang Dikerjakan:
1. Route GET /categories → daftar kategori aktif + jumlah event
2. Route GET /categories/{slug} → event published per kategori + filter

Definisi Selesai: Guest bisa lihat daftar kategori dan event per kategori.

---

## Tahap 15 — Forgot/Reset Password
**FR:** FR-01.2

Yang Dikerjakan:
1. Konfigurasi mail driver di .env
2. Route GET/POST /forgot-password → form input email
3. Route GET/POST /reset-password/{token} → form password baru
4. Link "Forgot password?" di halaman login

Definisi Selesai: User yang lupa password bisa reset via email.

---

## Tahap 16 — Polish & Hardening
**Non-Fungsional**

Yang Dikerjakan:
1. Audit N+1 query di semua halaman
2. Empty state di semua list page
3. Responsive test mobile/tablet
4. Accessibility: alt text, focus states, label form
5. npm run build sukses
6. Full test suite hijau

Definisi Selesai: Semua halaman fungsional, responsif, accessible, tanpa error.
