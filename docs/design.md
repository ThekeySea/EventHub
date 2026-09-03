# 🎨 Design System — EventHub

## 1. Teknologi

| Komponen | Teknologi |
|---|---|
| CSS Framework | Tailwind CSS 4 (via Vite) |
| JS Interactivity | Alpine.js (CDN) |
| Build Tool | Vite 8 |
| Font | Poppins (Google Fonts) |
| Icon | SVG inline (Heroicons style) |
| Layout | Laravel Blade components |

---

## 2. Design Tokens (CSS Custom Properties)

### 2.1 Warna

```css
/* Primary Palette */
--color-primary: #635BFF;        /* Ungu — tombol utama, aksen */
--color-primary-hover: #4F46E5;  /* Ungu lebih gelap — hover state */
--color-primary-light: #EEECFF;  /* Ungu sangat terang — bg badge/ikon */

/* Secondary Palette */
--color-secondary: #FFB547;      /* Kuning/Emas — badge featured, highlight */
--color-secondary-hover: #F5A623;
--color-secondary-light: #FFF8EC;

/* Neutral Palette */
--color-neutral-bg: #F8F9FC;     /* Abu terang — background halaman */
--color-neutral-surface: #FFFFFF; /* Putih — kartu, modal */
--color-neutral-text: #171717;   /* Hitam — teks utama */
--color-neutral-muted: #667085;  /* Abu — teks sekunder, label */
--color-neutral-border: #E4E7EC; /* Abu — border kartu, input */

/* Semantic Palette */
--color-success: #12B76A;        /* Hijau — status sukses, published */
--color-success-light: #ECFDF3;
--color-warning: #F79009;        /* Orange — status pending, peringatan */
--color-warning-light: #FFFAEB;
--color-error: #F04438;          /* Merah — error, hapus, rejected */
--color-error-light: #FEF3F2;
--color-info: #2E90FA;           /* Biru — info, link */
--color-info-light: #EFF8FF;
```

### 2.2 Border Radius

```css
--radius-sm: 8px;
--radius-md: 12px;
--radius-lg: 16px;
--radius-xl: 20px;
--radius-2xl: 24px;
--radius-pill: 9999px;
```

### 2.3 Font

```css
--font-sans: 'Poppins', ui-sans-serif, system-ui, sans-serif;
--font-poppins: 'Poppins', sans-serif;
```

### 2.4 Animasi

```css
--animate-float: float 4s ease-in-out infinite;
--animate-float-delayed: float 4s ease-in-out 2s infinite;
--animate-pulse-slow: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
```

---

## 3. Komponen Blade

### 3.1 Badge

**Props:**
- `variant`: primary | secondary | success | warning | danger | info | neutral
- `style`: subtle | solid | outline
- `size`: sm | md
- `withDot`: boolean
- `icon`: SVG string

**Penggunaan:**
```blade
<x-badge variant="success" size="sm" withDot>Published</x-badge>
<x-badge variant="warning">Pending</x-badge>
<x-badge variant="danger" style="solid">Rejected</x-badge>
```

### 3.2 Event Card

**Props:**
- `title`, `category`, `date`, `location`, `price`
- `image` (URL), `featured` (boolean), `href` (URL)
- `organizer`, `spotsLeft`, `rating`

**Pola:**
- Hover: shadow-xl, -translate-y-1.5, border-primary/40
- Image: aspect-[16/10], group-hover:scale-105
- Badge kategori di pojok kiri atas
- Tombol favorite di pojok kanan atas

### 3.3 Empty State

**Props:**
- `icon`, `title`, `description`
- `actionText`, `actionHref`, `actionVariant`
- `compact` (boolean)

**Pola:**
- Border dashed, centered, icon 16x16 rounded-2xl
- Title font-semibold, description text-neutral-muted

### 3.4 Alert

**Penggunaan:**
```blade
<x-alert type="success" dismissible="true">Berhasil!</x-alert>
<x-alert type="error">{{ $errors->first() }}</x-alert>
```

### 3.5 Input, Textarea, Button

**Input:**
```blade
<x-input label="Nama" name="name" :value="old('name')" placeholder="Masukkan nama" required />
```

**Button:**
```blade
<x-button variant="primary" href="/events">Jelajahi</x-button>
<x-button variant="secondary" size="sm">Batal</x-button>
```

---

## 4. Layout Patterns

### 4.1 Public Layout (`layouts/public.blade.php`)
```
<x-public-layout>
    <x-navbar />        <!-- Sticky, z-40 -->
    <main>{{ $slot }}</main>
    <x-footer />
</x-public-layout>
```

### 4.2 Admin Layout (`layouts/admin.blade.php`)
```
@extends('layouts.admin')
@section('content')
    <!-- Sidebar kiri + konten utama kanan -->
@endsection
```

### 4.3 Organizer Layout (`layouts/organizer.blade.php`)
```
@extends('layouts.organizer')
@section('content')
    <!-- Sidebar kiri + konten utama kanan -->
@endsection
```

---

## 5. Halaman Utama

### 5.1 Navbar (`components/navbar.blade.php`)
- **Desktop**: Logo "E" + "EventHub" | Beranda | Jelajahi | [Masuk / Avatar Dropdown]
- **Mobile**: Logo + Hamburger menu
- **Sticky**: `sticky top-0 z-40 bg-white/90 backdrop-blur-md`
- **Profile Dropdown**: Dashboard, Registrasi, Favorit, Profil, [Organizer/Admin link], Keluar

### 5.2 Homepage (`welcome.blade.php`)

| # | Section | Background | Data |
|---|---|---|---|
| 1 | **Hero** | Foto Unsplash + gradient overlay | `h-screen`, heading uppercase, 2 CTA buttons |
| 2 | **Search Bar** | White card, `-mt-24` overlap | Input + 3 dropdown (tema, format, kota) |
| 3 | **Tema Populer** | White | 6 kartu kategori + "Lihat Semua" |
| 4 | **Pilihan Acara** | Neutral bg | 3 kartu (Luring/Daring/Hybrid) |
| 5 | **Event Pilihan** | White | 4 kartu (registrasi terbanyak) |
| 6 | **Paling Disuka** | Neutral bg | 4 kartu (favorit terbanyak) |
| 7 | **Terbaru** | White | 6 kartu + "Lihat Semua" |
| 8 | **Langkah-Langkah** | Neutral bg | 4 step + connector line |
| 9 | **Testimoni** | White | 3 testimoni statis |
| 10 | **Parallax Organizer** | Neutral bg | Auto-scroll kartu + fade edges |
| 11 | **Tawaran CTA** | White | 2 kartu besar (Member/Organizer) |

### 5.3 Explore Events (`events/index.blade.php`)
- Search bar + 4 filter dropdown + sort
- Grid event cards (1-3 kolom responsive)
- Pagination

### 5.4 Event Detail (`events/show.blade.php`)
- Breadcrumb
- Banner image
- Title + meta (organizer, kategori, jenis)
- Deskripsi
- Detail grid (tanggal, lokasi, format, kapasitas, deadline)
- Sidebar: tombol daftar, tombol favorit, info organizer

---

## 6. Status Warna

### Event Status
| Status | Badge Variant | Label |
|---|---|---|
| draft | neutral | Draft |
| pending | warning | Pending |
| published | success | Published |
| rejected | danger | Rejected |
| cancelled | neutral | Cancelled |
| completed | info | Completed |

### Registration Status
| Status | Badge Variant |
|---|---|
| registered | success |
| cancelled | danger |
| attended | info |

---

## 7. Responsive Breakpoints

| Breakpoint | Gunakan |
|---|---|
| Default (< 640px) | Mobile: 1 kolom, stack |
| `sm:` (≥ 640px) | Tablet: 2-3 kolom |
| `lg:` (≥ 1024px) | Desktop: 3-4 kolom, sidebar |

---

## 8. Pola Umum

### Kartu
```blade
<div class="bg-white rounded-2xl border border-neutral-border p-6 shadow-sm hover:shadow-md transition-shadow">
```

### Tombol Utama
```blade
<button class="px-6 py-3 bg-primary text-white font-semibold text-sm rounded-xl hover:bg-primary-hover shadow-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
```

### Input
```blade
<input class="w-full rounded-xl border border-neutral-border bg-white px-4 py-3 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" />
```

### Section Spacing
```blade
<section class="py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
```
