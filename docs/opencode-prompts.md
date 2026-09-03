# 📋 Prompt OpenCode — EventHub (Fitur Kategori End-to-End)

Dokumen ini berisi rangkaian prompt siap-pakai untuk dieksekusi oleh OpenCode, tahap demi tahap.
**Cara pakai:** tempelkan **Prompt 0 (Master Context)** di awal sesi, lalu jalankan prompt per tahap secara berurutan. Setelah tiap tahap selesai, verifikasi dengan checklist di bagian bawah dokumen ini sebelum lanjut ke tahap berikutnya.

---

## PROMPT 0 — Master Context (tempel pertama kali / awal sesi)

```
Kamu bekerja pada project EventHub: platform web manajemen event berbasis Laravel 13 (PHP 8.3),
Blade + Tailwind CSS 4 + Alpine.js (via CDN) + Vite 8, database SQLite (dev), auth Laravel Fortify.

STRUKTUR YANG SUDAH ADA:
- Multi-role (admin/organizer/member) via middleware: app/Http/Middleware/{Admin,Organizer,Member}Middleware.php
- Routes dikelompokkan per role di routes/web.php dengan prefix & name (admin.*, organizer.*, member.*)
- FortifyServiceProvider meng-override LoginResponse/RegisterResponse -> redirect per role
- Admin CRUD "Categories" (Tema event) sudah lengkap: controller app/Http/Controllers/Admin/CategoryController.php,
  Form Request StoreCategoryRequest/UpdateCategoryRequest, views resources/views/admin/categories/{index,create,edit}.blade.php
- Organizer Event CRUD parsial: app/Http/Controllers/Organizer/EventController.php,
  Form Request StoreEventRequest/UpdateEventRequest, views resources/views/organizer/events/{index,create,edit}.blade.php
- Policy: app/Policies/EventPolicy.php
- Models: User, Category, Event, Registration, Favorite; factories UserFactory, CategoryFactory, EventFactory
- Seeders: UserSeeder, CategorySeeder, EventSeeder (DatabaseSeeder memanggil ketiganya)
- Komponen Blade reusable: x-alert, x-badge, x-button, x-input, x-textarea, x-event-card, x-stat-card, x-empty-state
- Layout admin: layouts/admin.blade.php + sidebar partial admin/partials/sidebar-content.blade.php
- Layout publik: layouts/public.blade.php + components/navbar.blade.php, components/footer.blade.php

KEPUTUSAN DESAIN TERKUNCI (JANGAN DIUBAH):
1. Status event: draft -> pending -> published (langsung publish setelah approve, TANPA status
   "approved" terpisah). Vocabulary lengkap: draft, pending, published, rejected, cancelled,
   completed. Nanti bertambah: cancel_requested.
2. KATEGORI = payung 5 dimensi:
   - Tema   -> tabel `categories` (sudah ada): teknologi, bisnis, seni, dst.
   - Jenis  -> tabel baru `event_types`: Daring (online), Luring (offline), Hybrid — CARA BERPARTISIPASI
   - Format -> tabel baru `event_formats`: Seminar, Webinar, Workshop, Konser, Festival, Pameran,
              Kompetisi, Gathering Komunitas, Lainnya — BENTUK ACARA (opsional bagi organizer)
   - Lokasi -> tabel baru `cities`: kota-kota Indonesia (+ opsi Virtual/Online)
   - Waktu  -> kolom events.start_at/end_at/timezone (sudah ada)
3. Kolom string lama `events.event_type` dan `events.city` DIBIARKAN sebagai data historis.
   Sumber kebenaran baru: FK `event_type_id`, `event_format_id`, `city_id` (semua nullable).
4. Validasi form event terpisah untuk mode DRAFT vs SUBMIT:
   - Draft: hanya wajib title (min 3 karakter); field lain opsional.
   - Submit for review (form punya hidden input submit_type=submit): validasi penuh + aturan
     kondisional Jenis: Luring/Hybrid wajib city_id+location; Daring/Hybrid wajib online_url valid.
5. Slug event: auto-generate dari title; bila title kosong saat simpan draft -> placeholder unik
   ("draft-" + Str::random(8)); cek keunikan, tambah suffix acak bila bentrok.
6. Halaman publik SELALU scope query: status='published' DAN end_at >= now(), selalu paginate,
   eager loading relasi yang ditampilkan (hindari N+1).

KONVENSI WAJIB:
- Ikuti pola kode existing (Form Request untuk validasi, policy untuk ownership, named routes).
- Jangan hapus/mengubah perilaku auth & middleware existing.
- Semua endpoint non-public wajib authorization server-side (bukan cuma sembunyikan tombol).
- Redirect aksi dengan flash message success/error (pola with('success', ...) sudah dipakai).
- Setelah selesai tiap tugas: jalankan "composer test" dan pastikan hijau; jalankan
  "php artisan migrate:fresh --seed" untuk memastikan migrasi & seeder jalan bersih.

Konfirmasi pemahamanmu atas konteks ini dengan ringkas sebelum menerima tugas berikutnya.
```

---

## PROMPT 1 — Tahap 1: Perbaikan Simpan Event Draft

```
TASK: Perbaiki alur simpan event draft di area Organizer.

MASALAH SAAT INI:
StoreEventRequest dan UpdateEventRequest mewajibkan hampir semua field (description, category_id,
start_at after:now, end_at, capacity, dll) sehingga tombol "Save Draft" gagal validasi bila data
belum lengkap. Padahal konsep draft = WIP. Selain itu:
- Str::slug(title) menghasilkan string kosong bila title kosong -> error unique/required membingungkan.
- EventController::store masih ada hack "$data['location'] = $data['location'] ?? 'Online'".
- EventPolicy::update masih mengizinkan edit saat status pending/cancelled.

YANG HARUS DIBUAT:
1. Refactor rules() di StoreEventRequest & UpdateEventRequest menjadi dua mode:
   - Mode DRAFT (default): hanya 'title' => required|string|min:3|max:160. Field lain nullable
     tapi tetap divalidasi FORMATNYA bila diisi (category_id exists, start_at/end_at date,
     capacity integer min:1, online_url url, dst).
   - Mode SUBMIT (terdeteksi dari input submit_type === 'submit'): validasi penuh seperti
     sekarang, plus aturan kondisional Jenis. Buat helper private selectedMode(): ?string yang
     resolve EventType::find(event_type_id)->slug (lihat tabel event_types di Tahap 2):
       - luring/hybrid -> city_id & location required
       - daring/hybrid -> online_url required|url
     Bila tabel event_types belum ada di tahap ini, buat stub migrasi+model minimalnya agar
     helper bisa jalan, dan finalisasi di Tahap 3.
2. prepareForValidation: slug aman - pakai input slug bila ada; bila tidak dan title ada ->
   Str::slug(title); bila title kosong -> 'draft-' . Str::random(8). Cek keunikan terhadap tabel
   events (kecuali id event sendiri pada update), tambahkan suffix '-' . Str::random(4) bila bentrok.
3. EventController@store: hapus hack location; pastikan status default 'draft' dan user_id +
   organizer_id = Auth::id() tetap diset.
4. EventController@update: logika submit_type tetap bekerja dengan validasi baru
   (submit_type=submit -> status pending + reset rejection_reason).
5. EventPolicy: update() hanya true bila status in ['draft','rejected'] (SRS FR-08.3);
   submit() hanya bila status in ['draft','rejected'].
6. Update test tests/Feature/Organizer/EventTest.php:
   - Draft minimal HANYA title berhasil tersimpan status draft.
   - Submit tanpa field wajib -> session has errors, status TIDAK berubah pending.
   - Submit lengkap -> status pending.
   - Sesuaikan payload test lama yang memakai 'event_type' string ('webinar'/'seminar') karena
     field tersebut diganti event_type_id (FK).

DEFINISI SELESAI: composer test hijau; simpan draft dengan judul saja berhasil.
```

---

## PROMPT 2 — Tahap 2: Fondasi Data Jenis, Format & Kota + CRUD Admin

```
TASK: Bangun 3 tabel referensi baru beserta CRUD Admin lengkap, mengikuti PERSIS pola Categories
yang sudah ada (controller + Form Request + views + toggle-status).

A. MIGRASI (4 file migrasi baru):
1. create_event_types_table: id, name, slug(unique), description(nullable text),
   is_active(bool default true), timestamps.
2. create_event_formats_table: struktur sama dengan event_types.
3. create_cities_table: id, name, slug(unique), province(nullable string),
   is_active(bool default true), timestamps.
4. add_category_dimensions_to_events_table: tambah ke events -
   foreignId('event_type_id')->nullable()->constrained('event_types')->nullOnDelete();
   foreignId('event_format_id')->nullable()->constrained('event_formats')->nullOnDelete();
   foreignId('city_id')->nullable()->constrained('cities')->nullOnDelete().
   Jangan sentuh kolom string lama event_type & city.

B. MODELS + RELASI:
- App\Models\EventType, App\Models\EventFormat, App\Models\City: fillable sesuai kolom,
  cast is_active boolean, relasi hasMany(Event::class).
- App\Models\Event: tambah fillable event_type_id, event_format_id, city_id; relasi belongsTo
  eventType(), format(), city(). Pertahankan relasi & scope lama.

C. CRUD ADMIN (untuk masing-masing EventType, EventFormat, City):
- Controller app/Http/Controllers/Admin/{EventTypeController,EventFormatController,CityController}.php
  meniru CategoryController persis: index (search name/slug + filter is_active + paginate 10),
  create, store, edit, update, toggleStatus.
- Form Request Store/Update per entitas meniru StoreCategoryRequest/UpdateCategoryRequest
  (auto-slug, name unique, is_active boolean).
- Route resource + toggle-status di grup middleware('admin') prefix('admin') name('admin.') di
  routes/web.php: admin.event-types.*, admin.event-formats.*, admin.cities.*
- Views resources/views/admin/event-types/{index,create,edit}.blade.php dan sama untuk
  event-formats serta cities - copy gaya dari views admin/categories (table card, toolbar
  search/filter, empty state, badge toggle aktif/nonaktif). Label: "Jenis Acara", "Format Acara",
  "Kota/Lokasi".
- Sidebar admin: edit resources/views/admin/partials/sidebar-content.blade.php, tambah 3 link nav
  baru (activeNav: 'event-types', 'event-formats', 'cities') dekat item Categories, icon SVG inline.

D. SEEDER:
- EventTypeSeeder: Daring (slug: daring), Luring (slug: luring), Hybrid (slug: hybrid).
- EventFormatSeeder: Seminar(seminar), Webinar(webinar), Workshop(workshop), Konser(konser),
  Festival(festival), Pameran(pameran), Kompetisi(kompetisi),
  Gathering Komunitas(community-gathering), Lainnya(lainnya).
- CitySeeder: Jakarta, Bandung, Surabaya, Yogyakarta, Semarang, Medan, Makassar, Denpasar,
  Batam, Malang + satu baris "Virtual / Online" (slug: virtual-online, province null).
- PENTING: EventSeeder existing MEMAKAI KOLOM YANG SUDAH DIHAPUS (event_date, start_time, price,
  quota, address) sehingga PASTI GAGAL di fresh seed. REWRITE EventSeeder dengan skema baru:
  start_at/end_at (Carbon), timezone Asia/Jakarta, capacity, location, city_id, event_type_id,
  event_format_id - ~10 event demo lintas tema/jenis/format/kota, campuran status (6 published
  tanggal masa depan, 2 pending, 2 draft). Daftarkan semua seeder baru di DatabaseSeeder sebelum
  EventSeeder.
- Update CategorySeeder agar juga set is_active => true.
- Update EventFactory: hapus field usang, pakai skema baru; tambah state helpers published(),
  pending(), online(), offline(), hybrid() untuk test.

DEFINISI SELESAI: php artisan migrate:fresh --seed jalan bersih; ketiga CRUD admin berfungsi;
composer test hijau.
```

---

## PROMPT 3 — Tahap 3: Form Event Organizer Terhubung Semua Dimensi

```
TASK: Hubungkan form create/edit event Organizer ke database Tema/Jenis/Format/Kota.

PERUBAHAN CONTROLLER (Organizer\EventController create & edit):
Pass ke view: $categories (aktif), $eventTypes (aktif), $formats (aktif), $cities (aktif).

PERUBAHAN VIEWS organizer/events/create.blade.php & edit.blade.php:
1. Dropdown "Theme" tetap (sudah dinamis dari categories).
2. GANTI dropdown "Event Type" hard-coded (seminar/webinar/dll) menjadi:
   a. Select "Jenis Acara" WAJIB - option dari $eventTypes (value=id, label=name).
      Bungkus form dengan Alpine.js: x-data="{ jenis: '{{ old('event_type_id', $event->event_type_id ?? '') }}' }"
      untuk show/hide section lokasi.
   b. Select "Format Acara" OPSIONAL (label "(optional)") - option dari $formats.
   c. Select "Kota" - option dari $cities.
3. Section "Location Details": venue/location + online_url. Venue & Kota tampil bila jenis =
   Luring/Hybrid; Online URL tampil bila jenis = Daring/Hybrid (x-show Alpine).
4. Edit view pre-select nilai existing ($event->event_type_id, format, city) dengan fallback old().
5. Tombol submit: tetap "Save Draft"; tambah tombol "Submit for Review" yang mengisi hidden input
   submit_type=submit (dua form terpisah atau JS set value).

VALIDASI (finalisasi refactor Tahap 1):
- Mode SUBMIT mewajibkan: event_type_id exists:event_types,id, category_id, description,
  start_at date after:now (hanya store; update boleh after_or_equal hari ini), end_at
  after:start_at, timezone, capacity integer min:1, plus kondisional Jenis (luring/hybrid ->
  city_id + location required; daring/hybrid -> online_url required|url). Format optional tapi
  bila diisi must exist:event_formats,id. City optional bila daring.
- Mode DRAFT: hanya title wajib; sisanya nullable dengan validasi format.

TEST (tests/Feature/Organizer/EventTest.php):
- Submit Luring tanpa city/location -> error; lengkap -> pending.
- Submit Daring tanpa online_url -> error; dengan URL -> pending.
- Draft minimal tetap works. Jalankan composer test.

DEFINISI SELESAI: alur UI lengkap manual: buat draft -> isi semua dimensi -> submit -> masuk DB
sebagai pending. Test hijau.
```

---

## PROMPT 4 — Tahap 4: Landing Page Publik + Explore/Search/Filter

```
TASK: Bangun discovery publik: homepage baru dan halaman Explore Events.

A. CONTROLLER PUBLIK BARU:
App\Http\Controllers\Public\EventController dengan:
1. home(): featuredEvents (published, upcoming, ambil 6, eager category.city.eventType),
   themes (categories aktif WITH COUNT event published, urut count desc),
   types (event_types aktif), formats (event_formats aktif).
2. explore(Request): Event::query() scope published + end_at >= now, dengan filter:
   - q (LIKE pada title/description/location)
   - category (slug categories), type (slug event_types), format (slug event_formats),
     city (slug cities)
   - date_from & date_to (rentang start_at)
   - sort: soonest (start_at asc, default) | newest (created_at desc)
   - paginate 9-12, withQueryString(); eager load category, city, eventType;
     pass juga opsi dropdown filter.
3. Routes public: GET '/' name('home'), GET '/events' name('events.index') - letakkan SEBELUM
   grup auth di routes/web.php.

B. VIEW BERANDA - ganti welcome.blade.php dengan home.blade.php (extend layouts.public):
- Hero: headline + form pencarian besar (GET /events, name q).
- Section "Jelajahi Berdasarkan Tema": grid kartu tema (nama + jumlah event) -> /events?category={slug}.
- Section "Berdasarkan Jenis": kartu Daring/Luring/Hybrid -> /events?type={slug}.
- Section "Format Populer": chips/kartu -> /events?format={slug}.
- Section "Event Mendatang": grid x-event-card (adaptasi props: title, category, date locale id,
  location/online, href).
- Empty state rapi bila belum ada data.

C. VIEW EXPLORE - resources/views/events/index.blade.php:
- Toolbar filter: keyword (value request('q')), select Tema/Jenis/Format/Kota, date_from/date_to,
  select sort, tombol Filter + Reset.
- Filter chips aktif: tiap filter tampil badge dengan tombol x yang menghapus parameter itu
  saja (pertahankan parameter lain).
- Grid hasil pakai x-event-card; pagination links(); empty state informatif.
- Responsif mobile-first, konsisten token design system existing (neutral-border, primary,
  font-poppins, rounded-2xl).

D. KUALITAS:
- Semua query publik scope published + upcoming; tidak ada kebocoran draft/pending/rejected.
- Tanggal Indonesia (Carbon translatedFormat).
- Kartu tanpa banner: gradien deterministik dari hash judul.

TEST BARU tests/Feature/Public/ExploreTest.php:
- Homepage 200 & hanya menampilkan published; draft/pending TIDAK muncul.
- Explore: filter kategori/jenis/kota, keyword, rentang tanggal, kombinasi, pagination, empty state.
- Event dengan end_at lewat tidak muncul.

DEFINISI SELESAI: guest: beranda -> klik kartu tema -> hasil terfilter -> ubah filter -> reset.
Composer test hijau.
```

---

## PROMPT 5 — Tahap 5: Verifikasi Akhir & Hardening

```
TASK: Audit menyeluruh hasil Tahap 1-4 dan perbaiki semua temuan.

CHECKLIST AUDIT:
1. composer test - perbaiki semua failure.
2. php artisan migrate:fresh --seed harus sukses dari nol (simulasi setup baru).
3. Audit N+1: semua list page (organizer events index, admin lists, homepage, explore) harus
   eager load relasi yang dirender.
4. Audit otorisasi: member tidak bisa /admin/* dan /organizer/* (403); organizer tidak bisa
   lihat/ubah event milik lain (403 via policy); guest redirect ke login; endpoint admin
   Jenis/Format/Kota hanya admin.
5. Audit validasi server-side di SEMUA Form Request (jangan percaya disabled attr HTML).
6. UX sweep: empty state tiap list, flash message tiap aksi, pesan error konsisten bahasanya.
7. Pastikan tidak ada dd()/dump()/console.log/TODO basi tertinggal.
8. npm run build sukses.

LAPORKAN: ringkas temuan & perbaikan dalam bullet list di akhir jawaban.
```

---

## Checklist Pemantauan (verifikasi setiap tahap)

| Tahap | Yang dicek |
|---|---|
| 1 | Simpan draft judul-saja via POST nyata; policy pending read-only; test hijau |
| 2 | `migrate:fresh --seed` bersih; EventSeeder baru tanpa kolom usang; 3 CRUD admin berfungsi |
| 3 | Aturan kondisional Jenis-lokasi benar di server (uji bypass JS); pre-fill edit form |
| 4 | Query publik ter-scope published+upcoming di SEMUA entry point (termasuk kartu homepage) |
| 5 | Diff menyeluruh: tanpa regresi auth/policy, tanpa dd()/TODO tertinggal |

**Red flags — langsung eskalasi bila muncul di output OpenCode:**
- Mengubah `FortifyServiceProvider` / middleware role tanpa alasan eksplisit
- Menambah kolom NOT NULL tanpa default pada tabel berisi data
- Menghapus kolom string `event_type`/`city` lama (harus dipertahankan historis)
- Membuat route publik DI DALAM grup `auth`
- Validasi kondisional hanya di JavaScript tanpa padanan server-side
