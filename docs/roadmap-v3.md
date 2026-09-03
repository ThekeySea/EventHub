# 🗺️ Roadmap EventHub v3 — Update Agustus 2026

## Status Saat Ini

### ✅ SUDAH SELESAI (~85%)

#### Fase 1: Auth & Roles
- [x] Fortify auth + role middleware (admin/organizer/member)
- [x] Login / Register pages
- [x] Role-based redirect after login
- [x] Forgot Password (`/forgot-password`)
- [x] Reset Password (`/reset-password/{token}`)
- [x] Link "Lupa password?" di halaman login

#### Fase 2: Admin
- [x] Admin Dashboard (data nyata + stats)
- [x] Categories CRUD (create/read/update/toggle status)
- [x] Event Types CRUD
- [x] Cities CRUD
- [x] Events moderation (list pending, approve, reject dengan alasan)
- [x] Event detail admin view

#### Fase 3: Organizer
- [x] Organizer Dashboard (real data: total events, draft, pending, published)
- [x] Event CRUD (create draft, edit, submit untuk review)
- [x] Form event dengan 5 dimensi (tema, jenis, format, kota, format acara)
- [x] Event detail + status approval + rejection reason
- [x] Cancel event (draft/pending)
- [x] Lihat daftar pendaftar per event

#### Fase 4: Public
- [x] Homepage 11 sections (Hero full-screen, Tema Populer, Pilihan Acara, Event Pilihan, Paling Disuka, Terbaru, Langkah-Langkah, Testimoni, Parallax Organizer, Tawaran CTA, Footer)
- [x] Navbar responsive (sticky, dropdown profile, mobile hamburger)
- [x] Search bar dengan 3 dropdown filter (tema, format, kota)
- [x] Explore `/events` dengan filter 4 dimensi
- [x] Event detail `/events/{slug}`

#### Fase 5: Member
- [x] Member Dashboard (stats, upcoming events, favorites, history)
- [x] My Registrations (list + cancel)
- [x] My Favorites (list + remove)
- [x] Profile update (nama, email, telepon)
- [x] Registrasi event (validasi: kapasitas, duplikat, deadline)
- [x] Favorit event (toggle, unique constraint)

#### Fase 6: Database & Infrastructure
- [x] 8 models (User, Category, Event, EventType, EventFormat, City, Registration, Favorite)
- [x] 17 migrations
- [x] 7 seeders (lengkap)
- [x] 34 tests hijau
- [x] Design tokens (custom Tailwind colors)

---

### ❌ BELUM DILAKUKAN (~15%)

#### Fase A: Public Categories (FR-02.5)
**Estimasi: 30-45 menit**

1. Route `GET /categories` — daftar kategori aktif + jumlah event published
2. Route `GET /categories/{slug}` — event published per kategori + filter
3. Controller: `Public/CategoryController`
4. Views: `categories/index.blade.php`, `categories/show.blade.php`
5. Update homepage "Tema Populer" → link ke `/categories/{slug}`
6. Update homepage "Lihat Semua Kategori" → link ke `/categories`

#### Fase B: Admin User Management (FR-09.4)
**Estimasi: 45-60 menit**

1. Route `GET /admin/users` — daftar user + search + filter role/status + pagination
2. Route `PATCH /admin/users/{user}` — update role, toggle active/inactive
3. Controller: `Admin/UserController`
4. Views: `admin/users/index.blade.php`, `admin/users/edit.blade.php`
5. Form Request: `UpdateUserRequest.php`
6. Tambah link "Users" di admin sidebar

#### Fase C: Admin Registrations View (FR-09.6)
**Estimasi: 20-30 menit**

1. Route `GET /admin/registrations` — tabel semua registrasi + filter event/member/status
2. Controller: `Admin/RegistrationController`
3. View: `admin/registrations/index.blade.php`
4. Tambah link "Registrations" di admin sidebar

#### Fase D: Hardening & Quality
**Estimasi: 1-1.5 jam**

1. Fix: Section Format kosong di event detail (`events/show.blade.php`)
2. Fix: Hapus warna Tailwind default (`text-emerald-400` di admin pending)
3. Hapus file `debug-email.blade.php` dan `home.blade.php` (tidak dipakai)
4. Tambah test: registration flow, favorites flow, admin moderation
5. Responsive check semua halaman
6. Empty state konsisten di semua list page
7. Accessibility: alt text, focus states, form labels
8. Audit N+1 query

---

### 📋 Urutan Rekomendasi

```
Fase A (Public Categories)    ← Public pages sesuai SRS
   ↓
Fase B (Admin Users)          ← Admin bisa kelola user
   ↓
Fase C (Admin Registrations)  ← Admin oversight
   ↓
Fase D (Hardening)            ← Quality assurance
```

### ⏱️ Estimasi Total: ~3-4 jam

---

### 📊 Statistik Project

| Komponen | Jumlah |
|---|---|
| Models | 8 |
| Controllers | 12 |
| Views | 50+ |
| Migrations | 17 |
| Seeders | 7 |
| Tests | 34 (hijau) |
| Routes | 37 |

### 🔑 Login Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@eventhub.test | password |
| Organizer | organizer@eventhub.test | password |
| Member | member@eventhub.test | password |
