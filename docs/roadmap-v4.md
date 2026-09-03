# 🗺️ Roadmap EventHub v4 — Update Agustus 2026

## Status Saat Ini (~95%)

### ✅ SUDAH SELESAI

#### Fase 1: Database & Model Foundation
- [x] Migration: payment_method, payment_info, deleted_at (events)
- [x] Migration: no_show_count, is_restricted (users)
- [x] Migration: cancelled_at, payment_confirmed_at, checked_in_at (registrations)
- [x] Event model: SoftDeletes, payment methods, helper methods
- [x] User model: no_show tracking, auto-restrict (onsite=1, upfront=5)
- [x] Registration model: 5 statuses, confirmPayment(), checkIn(), markNoShow()
- [x] Seeder: 2 upfront, 2 onsite, 7 free events
- [x] EventFactory updated

#### Fase 2: Admin Analytics Dashboard
- [x] Admin/AnalyticsController — query data 3 grafik
- [x] Route GET /admin/analytics
- [x] View: 3 Chart.js charts (User Mingguan, Event Bulanan, Trend Registrasi)
- [x] 4 stat cards (Total Users, Active, Events, Registrations)
- [x] Sidebar Analytics link
- [x] Chart.js installed via npm

#### Fase 3: Admin Enhanced
- [x] No-show info di admin user edit (count + status restricted)
- [x] Delete event dengan alasan (soft delete) dari admin
- [x] Route DELETE /admin/events/{event}
- [x] Danger Zone UI di admin event show

#### Fase 4: Organizer Payment & Check-in
- [x] Payment method radio buttons di form create/edit event
- [x] Payment info textarea (muncul saat "Bayar di Muka")
- [x] StoreEventRequest & UpdateEventRequest — validasi payment_method
- [x] Check-in buttons di organizer event registrations
- [x] Check-in route + controller method
- [x] No-show tracking otomatis saat check-in

#### Fase 5: Bug Fixes
- [x] Fix ParseError organizer event show (file terpotong)
- [x] Fix orphaned </span> di organizer layout
- [x] Fix missing right wrapper di organizer topbar

#### Fase 6: Auth & Roles (SEBELUMNYA)
- [x] Login, Register, Forgot/Reset Password
- [x] Role-based redirect

#### Fase 7: Admin CRUD (SEBELUMNYA)
- [x] Dashboard, Categories, Event Types, Cities
- [x] Events moderation (approve/reject)

#### Fase 8: Organizer (SEBELUMNYA)
- [x] Dashboard, Event CRUD, Detail, Cancel, Registrations

#### Fase 9: Public (SEBELUMNYA)
- [x] Homepage 11 sections, Navbar, Search Bar
- [x] Explore + Filter, Event Detail, Categories

#### Fase 10: Member (SEBELUMNYA)
- [x] Dashboard, Registrasi, Favorit, Profile

---

### ❌ BELUM DILAKUKAN

#### Fase 6: Registration Flow
- [ ] Bayar di muka → status pending_payment
- [ ] Info transfer ke member saat register
- [ ] Organizer confirm pembayaran
- [ ] No-show auto-detect setelah event selesai
- [ ] Restrict system + email warning (log)

#### Fase 7: Member Enhancement
- [ ] Filter riwayat event (semua/hadir/dibatalkan)
- [ ] Statistik pribadi (total event diikuti, total favorit)

#### Fase 8: Polish & Hardening
- [ ] Fix spacing homepage
- [ ] Audit warna konsisten (Tailwind default → custom tokens)
- [ ] Responsive check semua halaman
- [ ] Cleanup file tidak terpakai

---

### 📊 Statistik Project

| Komponen | Jumlah |
|---|---|
| Models | 8 |
| Controllers | 17 |
| Views | 61 |
| Migrations | 20 |
| Seeders | 7 |
| Tests | 53 (hijau) |
| Routes | 100+ |

### 🔑 Login Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@eventhub.test | password |
| Organizer | organizer@eventhub.test | password |
| Member | member@eventhub.test | password |
