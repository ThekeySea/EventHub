# 🗺️ Roadmap EventHub v5 — Update 1 September 2026

## 📊 Status Saat Ini (~96%)

---

### ✅ SUDAH SELESAI (11 Fase)

#### FASE 1: Database & Model Foundation
- [x] 21 migrations (events, users, registrations, categories, types, cities, formats, favorites, notifications)
- [x] 9 Models (User, Event, Category, EventType, City, EventFormat, Registration, Favorite, Notification)
- [x] Seeder: 10 events (6 published, 2 pending, 2 draft) + 6 users + 8 categories + 3 types + 11 cities
- [x] Banner URL accessor, payment methods, soft deletes, no-show tracking

#### FASE 2: Auth System
- [x] Login, Register, Logout (Laravel Fortify)
- [x] Forgot Password → email reset link
- [x] Reset Password (dengan token)
- [x] Role-based redirect setelah login

#### FASE 3: Admin Dashboard & CRUD
- [x] Admin Dashboard (stat cards: users, events, registrations, categories)
- [x] Categories CRUD + toggle status
- [x] Event Types CRUD + toggle status
- [x] Cities CRUD + toggle status
- [x] Users Management (list, filter, edit)
- [x] Event Moderation (pending queue, approve, reject dengan alasan)
- [x] Admin delete event (soft delete + alasan)
- [x] Danger Zone UI
- [x] Export CSV users (/admin/users/export)

#### FASE 4: Admin Analytics
- [x] 3 Chart.js charts (User Mingguan, Event Bulanan, Trend Registrasi)
- [x] 4 stat cards interaktif
- [x] Sidebar Analytics link

#### FASE 5: Organizer Area
- [x] Organizer Dashboard (stat cards)
- [x] Event CRUD (create, edit, show, index)
- [x] Submit event untuk review
- [x] Cancel event
- [x] Lihat pendaftar per event
- [x] Check-in pendaftar + no-show tracking
- [x] Confirm payment (upfront)
- [x] Export CSV pendaftar (/organizer/events/{event}/export)

#### FASE 6: Member Area
- [x] Member Dashboard (stat cards + ringkasan)
- [x] Registrasi event (DB::transaction + lockForUpdate)
- [x] Batalkan registrasi
- [x] Favorites (add/remove/view)
- [x] Profil (update name, email, phone, password)
- [x] Filter riwayat event (semua/aktif/hadir/menunggu bayar/dibatalkan/no-show)
- [x] Statistik pribadi clickable
- [x] Notifikasi in-app (lihat, mark read, hapus)

#### FASE 7: Public Pages
- [x] Homepage (8 sections: Hero, Search, Pilihan Acara, Event Teratas, Terbaru, Cara Kerja, Testimoni, CTA)
- [x] Navbar (responsive, role-aware, smooth scroll, back to top)
- [x] Search + Filter (tema, format, kota — modal di mobile)
- [x] Explore events page
- [x] Event detail page
- [x] Event calendar view (/events/calendar)
- [x] Categories index + show
- [x] About page (quote + visi/misi)
- [x] Footer ungu gelap (4 kolom: Brand, Navigasi, Akun, Kontak)

#### FASE 8: Design System
- [x] Custom Tailwind tokens (primary #635BFF, secondary #FFB547, neutral, semantic)
- [x] Custom components (button, badge, card, input, textarea, stat-card, event-card)
- [x] Color audit: semua Tailwind default → custom tokens (termasuk auth views)
- [x] 53 tests hijau ✅

#### FASE 9: Homepage Fix & Polish
- [x] Cara Kerja → 2 kolom interaktif (kiri langkah, kanan deskripsi)
- [x] Filter Modal Mobile (3 tombol + modal popup Alpine.js)
- [x] Skeleton Loading homepage (purple)
- [x] Smooth scroll navigation
- [x] Back button admin/organizer (history.back())
- [x] Nav "Tentang" di navbar
- [x] Logo → About page
- [x] Back to top button
- [x] Event Teratas section (gabung favorit + registrasi + badge ranking)
- [x] Testimoni parallax (auto + manual scroll, 10 komentar + rating bintang)

#### FASE 10: Backend Hardening
- [x] Registration atomic (DB::transaction + lockForUpdate)
- [x] Slug unique validation (StoreEventRequest + UpdateEventRequest)
- [x] Auth views → custom tokens (forgot-password, reset-password: 0 gray tersisa)
- [x] Member layout sidebar (Dashboard, Registrasi, Favorit, Profil, Notifikasi)
- [x] 403/404 custom pages

#### FASE 11: Notifikasi & Enhanced UX
- [x] Notification Model + Migration + Controller (index, markAsRead, markAllAsRead, destroy)
- [x] Notification Routes (4 routes)
- [x] Notification View (list, badge, pagination, empty state)
- [x] Member Sidebar → link "Notifikasi"
- [x] Trigger: admin approve/reject → notif ke organizer
- [x] Trigger: registrasi berhasil → notif ke member
- [x] Badge notifikasi di public navbar (bell icon + unread count)
- [x] Event calendar view (Alpine.js grid, prev/next month, upcoming events)
- [x] Export CSV admin users (/admin/users/export)
- [x] Export CSV organizer pendaftar (/organizer/events/{event}/export)

---

### 📋 Sisa Pengembangan

#### Phase 12: Testing & Quality
**Estimasi: 2-3 jam**

| # | Tugas | Prioritas | Assign |
|---|---|:---:|---|
| 1 | Responsive audit semua halaman | 🔴 | OpenCode |
| 2 | Feature test tambahan (notifikasi, calendar) | 🟡 | Cbuff |
| 3 | Performance check (N+1 queries) | 🟡 | Cbuff |
| 4 | Accessibility check (alt text, keyboard, contrast) | 🟢 | OpenCode |

---

## 📊 Statistik Project

| Komponen | Jumlah |
|---|---|
| Models | 9 |
| Controllers | 18 (Admin:7, Organizer:2, Member:4, Public:2, Auth:1) |
| Views | 65 blade files |
| Migrations | 21 |
| Seeders | 7 + event_data.json |
| Policies | 1 (EventPolicy) |
| Form Requests | 9 |
| Tests | 53 (hijau ✅) |
| Routes | 53 (web.php) |
| CSS Tokens | primary, secondary, neutral, semantic + animations |

## 🗃️ Database

| Data | Jumlah |
|---|---|
| Users | 6 |
| Events | 10 (6 published, 2 pending, 2 draft) |
| Categories | 8 |
| Event Types | 3 |
| Cities | 11 |
| Registrations | 0 |
| Favorites | 0 |
| Notifications | 0 |

## 🔑 Login Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@eventhub.test | password |
| Organizer | organizer@eventhub.test | password |
| Member | member@eventhub.test | password |
