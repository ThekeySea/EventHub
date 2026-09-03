# 📋 Prompt Antigravity — EventHub (Sisa Pengembangan)

Dokumen ini berisi rangkaian prompt siap-pakai untuk dieksekusi oleh Antigravity, tahap demi tahap.
**Cara pakai:** tempelkan **Prompt 0 (Master Context)** di awal sesi, lalu jalankan prompt per tahap.

---

## PROMPT 0 — Master Context (tempel pertama kali)

```
Kamu bekerja pada project EventHub: platform web manajemen event berbasis Laravel 13 (PHP 8.3),
Blade + Tailwind CSS 4 + Alpine.js + Vite 8, database MySQL (Laragon), auth Laravel Fortify.

STRUKTUR YANG SUDAH ADA:
- Multi-role (admin/organizer/member) via middleware
- Routes dikelompokkan per role di routes/web.php (admin.*, organizer.*, member.*)
- FortifyServiceProvider: LoginResponse -> redirect per role
- 8 Models: User, Category, Event, EventType, EventFormat, City, Registration, Favorite
- 12 Controllers: Admin (5), Organizer (2), Member (4), Public (1)
- 50+ Blade views dengan design system custom tokens
- 34 tests hijau, 7 seeders lengkap

DATA REFERENCE:
- Categories (Tema): Music, Education, Technology, Sport, Business, Art, Community, Competition
- Event Types (Jenis): Daring, Luring, Hybrid
- Event Formats (Format): Seminar, Webinar, Workshop, Konser, Festival, Pameran, Kompetisi, Gathering Komunitas, Lainnya
- Cities: Jakarta, Bandung, Surabaya, Yogyakarta, Semarang, Medan, Makassar, Denpasar, Batam, Malang, Virtual/Online

DESIGN SYSTEM (custom Tailwind tokens - JANGAN pakai warna Tailwind default):
- Primary: #635BFF (ungu) - bg-primary, text-primary, bg-primary-light
- Secondary: #FFB547 (emas) - bg-secondary, text-secondary
- Neutral: bg-neutral-bg, text-neutral-text, text-neutral-muted, border-neutral-border
- Success: #12B76A - bg-success, text-success
- Warning: #F79009 - bg-warning, text-warning
- Error: #F04438 - bg-error, text-error
- Info: #2E90FA - bg-info, text-info
- Radius: rounded-xl (12px), rounded-2xl (24px)
- Font: Poppins (font-poppins)

STATUS EVENT: draft -> pending -> published -> (rejected/cancelled/completed)

KONVENSI WAJIB:
- Gunakan custom design tokens, JANGAN text-emerald-*, bg-rose-*, dll
- Redirect aksi dengan flash message success/error
- Named routes pada semua tautan
- Eager loading relasi untuk hindari N+1
- Public pages SELALU scope: status='published' + end_at >= now()
- Jalankan php artisan test setelah perubahan - pastikan hijau

Konfirmasi pemahamanmu sebelum menerima tugas berikutnya.
```

---

## PROMPT 1 — Fase A: Public Categories Pages

```
TASK: Buat halaman publik untuk kategori event (/categories dan /categories/{slug}).

YANG DIBUAT:
1. Controller: app/Http/Controllers/Public/CategoryController.php
   - index(): daftar kategori aktif + jumlah event published (withCount)
   - show($slug): event published per kategori + filter + pagination

2. Routes (SEBELUM grup auth di routes/web.php):
   - GET /categories -> Public\CategoryController@index -> name('categories.index')
   - GET /categories/{slug} -> Public\CategoryController@show -> name('categories.show')

3. Views:
   - resources/views/categories/index.blade.php
     Grid kategori (3-6 kolom), kartu: nama, deskripsi, jumlah event
   - resources/views/categories/show.blade.php
     Header kategori + filter bar + grid event cards + pagination + empty state

4. Update navbar: tambah link "Kategori" di desktop nav

POLA: Controller meniru Public\EventController. Views extend x-public-layout.
Filter bar meniru events/index.blade.php.

TEST: /categories 200, /categories/{slug} 200 + filter, /categories/x 404
```

---

## PROMPT 2 — Fase B: Admin User Management

```
TASK: Buat CRUD admin untuk mengelola pengguna (FR-09.4).

YANG DIBUAT:
1. Controller: app/Http/Controllers/Admin/UserController.php
   - index(): search (name/email) + filter (role, is_active) + paginate 15
   - edit($user): form edit
   - update($user): update role + is_active. Admin TIDAK BISA nonaktifkan diri sendiri.

2. Form Request: app/Http/Requests/UpdateUserRequest.php

3. Routes:
   - GET /admin/users, GET /admin/users/{user}/edit, PATCH /admin/users/{user}

4. Views:
   - admin/users/index.blade.php (table + search + filter)
   - admin/users/edit.blade.php (form: name, email, role, is_active)

5. Sidebar: tambah link "Users"

YANG TIDAK BOLEH: Admin tidak bisa nonaktifkan diri sendiri.
Jangan pakai warna Tailwind default.

TEST: Admin bisa list/edit user, admin tidak bisa nonaktifkan diri sendiri, 403 untuk non-admin.
```

---

## PROMPT 3 — Fase C: Admin Registrations View

```
TASK: Buat halaman admin untuk melihat semua registrasi event (FR-09.6).

YANG DIBUAT:
1. Controller: app/Http/Controllers/Admin/RegistrationController.php
   - index(): eager load user, event + filter + paginate 20

2. Route: GET /admin/registrations

3. View: admin/registrations/index.blade.php
   Table: user, event, registration code, status, date + filter + pagination

4. Sidebar: tambah link "Registrations"

TEST: Admin bisa lihat registrasi + filter.
```

---

## PROMPT 4 — Fase D: Hardening

```
TASK: Audit dan perbaikan kualitas.

CHECKLIST:
1. Fix section Format kosong di events/show.blade.php
2. Ganti text-emerald-400 -> text-success di admin pending
3. Hapus debug-email.blade.php dan home.blade.php
4. Audit N+1 query + eager loading
5. Empty state konsisten (x-empty-state)
6. Responsive check semua halaman
7. Accessibility: alt text, label, focus states
8. npm run build sukses

LAPORKAN temuan dan perbaikan.
```

---

## Checklist Verifikasi

| Tahap | Yang Dicek |
|---|---|
| 1 | /categories tampil + /categories/{slug} + filter bekerja |
| 2 | Admin list/edit/toggle user + tidak bisa nonaktifkan diri sendiri |
| 3 | Admin lihat semua registrasi + filter |
| 4 | Tidak ada warna Tailwind default + empty state + test hijau |
