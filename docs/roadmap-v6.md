# 🗺️ Roadmap EventHub v6 — Update 2 September 2026

## 📊 Status Saat Ini

### ✅ SUDAH SELESAI

| Fase | Fitur | Status |
|---|---|:---:|
| 1-11 | Fondasi, Auth, Admin CRUD, Organizer, Member, Public Pages, Homepage, Notifikasi, Registration Flow | ✅ |
| Bug Fix | FormRequest, Submit rules, Banner logic, Admin notification, Registration atomic | ✅ |
| 12 | Audit Log + Event Report | ✅ |
| 13 | Registration Detail + Waitlist | ✅ |
| 14 | Registrant Communication + Event Analytics | ✅ |
| 15 | Organizer Performance Dashboard | ✅ |

### 📊 Statistik Proyek

| Komponen | Jumlah |
|---|---|
| Models | 12 |
| Controllers | 21 |
| Views | 72 |
| Migrations | 24 |
| Routes | 63 |
| Tests | 53 ✅ |

---

## 🔴 FASE 16: Sisa MVP SRS (Halaman yang Belum Ada)

| # | Tugas | SRS Ref | Prioritas |
|---|---|---|:---:|
| 1 | Halaman **Ubah Kata Sandi** (`/profile/password`) — form password saat ini + password baru + konfirmasi | FR-01.6 | 🔴 |
| 2 | Halaman **Detail Registrasi Member** (`/my-registrations/{registration}`) — status, waktu, aksi batalkan | FR-06.6 | 🔴 |
| 3 | **Auto-restrict no-show** — logika otomatis batasi akun sesuai threshold (onsite: 1x, upfront: 5x) | FR-06 | 🔴 |
| 4 | **Notifikasi email infrastruktur** — siapkan Mail class + config, tapi kirim via database dulu (tanpa SMTP) | FR-10 | 🟡 |

---

## 🟡 FASE 17: Hardening & Konsistensi

| # | Tugas | Prioritas |
|---|---|:---:|
| 1 | Audit **semua warna Tailwind default** → custom tokens (bg-emerald, bg-rose, dll masih ada di beberapa view) | 🔴 |
| 2 | **Responsive audit** — cek semua halaman di mobile (320px), tablet (768px), desktop | 🔴 |
| 3 | **Empty state** konsisten di semua halaman (registrasi kosong, event kosong, favorit kosong) | 🟡 |
| 4 | **Skeleton loading** di homepage + explore + dashboard member | 🟡 |
| 5 | **Accessibility** — alt text banner, label form, focus visible, kontras warna | 🟡 |

---

## 🟢 FASE 18: Fitur Tambahan (Post-MVP)

| # | Tugas | Estimasi |
|---|---|---|
| 1 | **Event Clone/Duplicate** — organizer bisa duplikat event sebagai draft | 1 jam |
| 2 | **Bulk Moderation** — admin multi-select approve/reject pending events | 2 jam |
| 3 | **Waitlist Settings** — batas max waitlist, auto-expire saat event dimulai | 1 jam |
| 4 | **SEO Basics** — meta title, description, OG tags di semua halaman publik | 1 jam |
| 5 | **Export CSV** — registrasi per event, daftar event, audit log | 1 jam |
| 6 | **Event Calendar View** — tampilan kalender untuk event mendatang | 2 jam |

---

## 🔑 Login Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@eventhub.test | password |
| Organizer | organizer@eventhub.test | password |
| Member | member@eventhub.test | password |

---

## 📋 Peta Halaman SRS vs Realisasi

| Halaman | URL | Status |
|---|---|:---:|
| Beranda | `/` | ✅ |
| Jelajahi Event | `/events` | ✅ |
| Detail Event | `/events/{slug}` | ✅ |
| Kategori | `/categories` | ✅ |
| Event per Kategori | `/categories/{slug}` | ✅ |
| Tentang Kami | `/about` | ✅ |
| Login | `/login` | ✅ |
| Register | `/register` | ✅ |
| Lupa Kata Sandi | `/forgot-password` | ✅ |
| Reset Kata Sandi | `/reset-password/{token}` | ✅ |
| Dashboard Member | `/dashboard` | ✅ |
| Registrasi Saya | `/my-registrations` | ✅ |
| Detail Registrasi | `/my-registrations/{registration}` | ❌ |
| Favorit Saya | `/favorites` | ✅ |
| Profil | `/profile` | ✅ |
| Ubah Kata Sandi | `/profile/password` | ❌ |
| Dashboard Organizer | `/organizer` | ✅ |
| Event Organizer | `/organizer/events` | ✅ |
| Buat Event | `/organizer/events/create` | ✅ |
| Edit Event | `/organizer/events/{event}/edit` | ✅ |
| Registrasi Event | `/organizer/events/{event}/registrations` | ✅ |
| Detail Registrasi | `/organizer/events/{event}/registrations/{registration}` | ✅ |
| Analytics Event | `/organizer/events/{event}/analytics` | ✅ |
| Dashboard Admin | `/admin` | ✅ |
| Event Pending | `/admin/events/pending` | ✅ |
| Semua Event | `/admin/events` | ✅ |
| Detail Event | `/admin/events/{event}` | ✅ |
| Pengguna | `/admin/users` | ✅ |
| Kategori | `/admin/categories` | ✅ |
| Jenis Event | `/admin/event-types` | ✅ |
| Kota | `/admin/cities` | ✅ |
| Audit Log | `/admin/audit-logs` | ✅ |
| Laporan Event | `/admin/reports` | ✅ |
| Kinerja Organizer | `/admin/organizers` | ✅ |
| Analytics Dashboard | `/admin/analytics` | ✅ |
