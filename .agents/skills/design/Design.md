# EventHub --- Design Specification

> **Dokumen ini adalah source of truth desain dan arsitektur UI/UX
> EventHub.** Dokumen ditulis agar dapat dibaca oleh manusia maupun
> coding agent/AI agent. Agent harus mengikuti aturan, struktur, naming,
> role, flow, dan acceptance criteria di dokumen ini sebelum membuat
> atau mengubah UI.

------------------------------------------------------------------------

## 1. Project Identity

### Nama

EventHub

### Tagline

Discover. Join. Experience.

### Deskripsi

EventHub adalah platform web untuk menemukan, mendaftar, membeli tiket,
dan mengikuti event. Platform memiliki dua role utama:

-   `member`: pengguna/peserta event
-   `admin`: pengelola event dan data platform

### Tujuan Produk

1.  Memusatkan informasi event dalam satu platform.
2.  Mempermudah Member menemukan event.
3.  Mempermudah Member membeli dan mengelola tiket.
4.  Mempermudah Admin membuat dan mengelola event.
5.  Memusatkan data tiket, peserta, transaksi, dan laporan.

------------------------------------------------------------------------

## 2. Product Principles

Semua implementasi UI/UX harus mengikuti prinsip berikut:

1.  **Clear** --- informasi event harus mudah dipahami.
2.  **Simple** --- user flow tidak boleh memiliki langkah yang tidak
    diperlukan.
3.  **Consistent** --- komponen dan spacing harus konsisten.
4.  **Responsive** --- desktop, tablet, dan mobile harus didukung.
5.  **Action-oriented** --- CTA utama harus mudah ditemukan.
6.  **Accessible** --- gunakan contrast yang baik, label form yang
    jelas, dan state yang dapat dipahami.
7.  **Data-driven** --- angka dashboard dan status harus berasal dari
    data aplikasi, bukan hardcoded setelah backend tersedia.

------------------------------------------------------------------------

## 3. Technology Context

Target implementation:

-   Framework: Laravel
-   Frontend default: Blade
-   Interactive UI: Livewire jika diperlukan
-   CSS: Tailwind CSS
-   Database: MySQL
-   Local development: Laragon
-   Design/prototyping: Figma

### Implementation Rule

Jangan menambahkan framework frontend besar seperti React/Vue kecuali
diminta secara eksplisit.

Prioritaskan:

-   Blade components
-   reusable partials
-   Tailwind utility classes
-   Livewire untuk interaksi yang membutuhkan server-side state

------------------------------------------------------------------------

# 4. Roles

## 4.1 Member

Member adalah peserta event.

Member dapat:

-   melihat event
-   mencari event
-   filter event
-   melihat detail event
-   memilih tiket
-   checkout
-   melihat transaksi
-   melihat digital ticket
-   melihat profile

Member tidak dapat:

-   membuat event
-   mengubah event
-   menghapus event
-   mengelola member
-   melihat laporan admin

------------------------------------------------------------------------

## 4.2 Admin

Admin adalah pengelola platform/event.

Admin dapat:

-   melihat dashboard
-   membuat event
-   mengedit event
-   menghapus event
-   publish/cancel event
-   mengelola kategori
-   mengelola tiket
-   melihat peserta
-   melihat transaksi
-   melihat member
-   melihat laporan

Admin tidak menggunakan UI Member untuk operasi administrasi jika
tersedia Admin Dashboard yang sesuai.

------------------------------------------------------------------------

# 5. Information Architecture

``` text
EventHub
|
+-- Public
|   +-- Home
|   +-- Explore Events
|   +-- Categories
|   +-- Event Detail
|   +-- Login
|   +-- Register
|
+-- Member
|   +-- Dashboard
|   +-- My Tickets
|   +-- Transactions
|   +-- Profile
|   +-- Checkout
|
+-- Admin
    +-- Dashboard
    +-- Events
    +-- Categories
    +-- Tickets
    +-- Participants
    +-- Transactions
    +-- Members
    +-- Reports
```

------------------------------------------------------------------------

# 6. Route Groups

Gunakan pemisahan route berdasarkan akses.

``` text
/
 /events
 /events/{event}
 /categories/{category}
 /login
 /register

/member
/member/dashboard
/member/tickets
/member/transactions
/member/profile
/member/checkout

/admin
/admin/dashboard
/admin/events
/admin/events/create
/admin/events/{event}/edit
/admin/categories
/admin/tickets
/admin/participants
/admin/transactions
/admin/members
/admin/reports
```

### Authorization

-   Public route: guest dan authenticated user boleh mengakses sesuai
    kebutuhan.
-   `/member/*`: hanya authenticated `member`.
-   `/admin/*`: hanya authenticated `admin`.
-   Jangan hanya menyembunyikan menu; backend harus benar-benar
    melakukan authorization.

------------------------------------------------------------------------

# 7. Design Language

## Visual Direction

Gunakan gaya:

-   modern
-   clean
-   premium
-   energetic
-   trustworthy
-   digital platform

Event image menjadi visual utama pada discovery page.

Hindari desain yang terlalu:

-   ramai
-   penuh gradient
-   skeuomorphic
-   menggunakan terlalu banyak shadow
-   menggunakan terlalu banyak warna

------------------------------------------------------------------------

# 8. Color System

## Primary

``` text
Primary: #635BFF
```

Penggunaan:

-   primary button
-   active navigation
-   links
-   selected state
-   brand accent

## Secondary

``` text
Secondary: #FFB547
```

Penggunaan:

-   highlight
-   featured badge
-   attention state yang tidak bersifat error

## Neutral

``` text
Background: #F8F9FC
Surface: #FFFFFF
Text: #171717
Muted Text: #667085
Border: #E4E7EC
```

## Semantic

``` text
Success: #12B76A
Warning: #F79009
Error: #F04438
Info: #2E90FA
```

### Color Rule

Jangan memilih warna baru untuk komponen individual jika token yang
tersedia sudah sesuai.

------------------------------------------------------------------------

# 9. Typography

Font utama:

``` text
Poppins
```

Hierarchy:

``` text
H1: 40px / Bold
H2: 32px / Bold
H3: 24px / SemiBold
H4: 20px / SemiBold
Body: 16px / Regular
Small: 14px / Regular
Caption: 12px / Regular
```

Untuk mobile, heading dapat diturunkan ukurannya secara responsive.

### Typography Rule

-   Heading harus jelas secara hierarchy.
-   Body text jangan terlalu kecil.
-   Gunakan `font-semibold` untuk label penting.
-   Jangan menggunakan lebih dari dua font family.

------------------------------------------------------------------------

# 10. Spacing System

Gunakan spacing berbasis kelipatan 4.

Contoh:

``` text
4px
8px
12px
16px
20px
24px
32px
40px
48px
64px
80px
```

Prioritas umum:

-   card padding: 20--24px
-   section gap: 48--80px
-   form field gap: 16px
-   button internal horizontal padding: 16--20px

Jangan menggunakan nilai spacing acak tanpa alasan desain.

------------------------------------------------------------------------

# 11. Border Radius

Gunakan radius modern dan konsisten:

``` text
Small: 8px
Medium: 12px
Large: 16px
Pill: 9999px
```

Rekomendasi:

-   Input: 10--12px
-   Card: 16px
-   Button: 10--12px
-   Badge: pill
-   Modal: 16px

------------------------------------------------------------------------

# 12. Shadow

Gunakan shadow secara minimal.

Card default:

``` text
shadow-sm
```

Modal/dropdown:

``` text
shadow-lg
```

Hindari shadow besar pada semua komponen.

------------------------------------------------------------------------

# 13. Core Components

Semua halaman harus menggunakan reusable components jika komponen yang
sama sudah tersedia.

Minimum component library:

``` text
Button
Input
Textarea
Select
Checkbox
Radio
Badge
Card
EventCard
CategoryCard
Modal
Dropdown
Navbar
Footer
Sidebar
Topbar
Table
Pagination
Tabs
Alert
Toast
EmptyState
LoadingState
Skeleton
Breadcrumb
StatCard
```

------------------------------------------------------------------------

# 14. Button System

## Primary

Digunakan untuk CTA utama.

Contoh:

``` text
Explore Events
Get Ticket
Create Event
Save Event
Checkout
```

Style:

-   background: Primary
-   text: white
-   rounded: 10--12px
-   clear hover state

## Secondary

Untuk action alternatif.

Contoh:

``` text
View Details
Cancel
Back
```

## Danger

Untuk destructive action.

Contoh:

``` text
Delete Event
Cancel Event
```

Gunakan warna semantic `Error`.

------------------------------------------------------------------------

# 15. Navbar

## Public Navbar

Struktur:

``` text
[EventHub]

Events
Categories

Search

Login
[Join Event]
```

Desktop:

-   logo di kiri
-   navigation di tengah
-   auth CTA di kanan

Mobile:

-   logo
-   menu trigger
-   navigation dalam mobile menu

## Member Navbar

Tampilkan:

``` text
EventHub
Events
My Tickets
Transactions
[Avatar]
```

## Admin Topbar

Admin menggunakan sidebar + topbar.

------------------------------------------------------------------------

# 16. Public Home Page

## Struktur

``` text
Navbar
Hero
Search Event
Popular Categories
Featured Events
Upcoming Events
How It Works
CTA
Footer
```

## Hero

Headline:

``` text
Discover Events
That Matter.
```

Supporting text:

``` text
Find events, get your tickets, and experience something memorable.
```

CTA:

``` text
Explore Events
```

Search:

``` text
Search events, categories, or locations...
```

Hero image harus mendukung tema event.

------------------------------------------------------------------------

# 17. Popular Categories

Kategori awal:

``` text
Music
Education
Technology
Business
Sports
Community
```

Optional:

``` text
Arts & Culture
Food & Lifestyle
```

Setiap category card dapat menampilkan:

-   icon
-   category name
-   jumlah event

Contoh:

``` text
[icon]
Music
24 Events
```

Kategori harus berasal dari database ketika backend sudah tersedia.

Jangan hardcode jumlah event pada production UI.

------------------------------------------------------------------------

# 18. Event Card

Event card adalah komponen utama discovery.

Struktur:

``` text
+---------------------------+
|       Event Image         |
|                           |
| [Category]                |
+---------------------------+
| Event Title               |
| Date                      |
| Location                  |
|                           |
| From Rp xxx.xxx           |
| [View Details]            |
+---------------------------+
```

Prioritas informasi:

1.  image
2.  title
3.  date
4.  location
5.  starting price
6.  CTA

Judul harus dapat dipotong dengan line clamp agar card tetap konsisten.

------------------------------------------------------------------------

# 19. Explore Events

Struktur:

``` text
Page Header
Search
Filter
Sort
Event Grid
Pagination
```

Filter minimum:

``` text
Category
Date
Location
Price
```

State:

``` text
Default
Loading
Results
Empty
Error
```

Empty state:

``` text
No events found.
Try changing your search or filters.
```

------------------------------------------------------------------------

# 20. Event Detail

Struktur:

``` text
Breadcrumb
Hero Image
Event Title
Category
Date
Location
Description
Event Schedule
Organizer
Ticket Options
CTA
Related Events
```

Ticket panel harus jelas:

``` text
Regular
Rp100.000
Available: 120
[Select]

VIP
Rp250.000
Available: 25
[Select]
```

Jika tiket habis:

``` text
Sold Out
```

Jangan tampilkan CTA pembelian aktif untuk tiket yang sudah sold out.

------------------------------------------------------------------------

# 21. Checkout

Flow:

``` text
Event Detail
    ↓
Select Ticket
    ↓
Checkout
    ↓
Payment
    ↓
Success
```

Checkout harus menampilkan:

``` text
Event
Ticket Type
Quantity
Unit Price
Subtotal
Total
Payment Method
```

CTA:

``` text
Continue Payment
```

Jangan menyembunyikan total harga.

------------------------------------------------------------------------

# 22. Digital Ticket

Setelah order berhasil dibayar:

``` text
Event Name
Member Name
Ticket Type
Date
Location
Ticket Code
QR Code
```

Status:

``` text
Valid
Used
Expired
```

Ticket harus memiliki visual hierarchy yang kuat.

------------------------------------------------------------------------

# 23. Member Dashboard

Struktur:

``` text
Welcome, {name}

Upcoming Events
My Tickets
Recent Transactions

[Event Card]
[Ticket Card]
[Transaction List]
```

Jika tidak ada data:

``` text
No upcoming events.
Explore events to get started.
```

------------------------------------------------------------------------

# 24. Admin Dashboard

Admin dashboard menggunakan layout:

``` text
Sidebar
Topbar
Main Content
```

Stat cards:

``` text
Total Events
Total Members
Tickets Sold
Revenue
```

Sections:

``` text
Revenue Chart
Ticket Sales
Recent Events
Recent Transactions
```

Semua angka harus berasal dari backend.

------------------------------------------------------------------------

# 25. Admin Event Management

Table:

``` text
Event
Category
Date
Tickets
Status
Actions
```

Status badge:

``` text
Draft
Published
Ongoing
Completed
Cancelled
```

Actions:

``` text
View
Edit
Delete
Publish
Cancel
```

Destructive action harus menggunakan confirmation modal.

------------------------------------------------------------------------

# 26. Admin Create Event

Form:

``` text
Event Title
Category
Description
Image
Location
Start Date
End Date
Status
```

Validation error harus muncul dekat field terkait.

Submit:

``` text
Save Draft
Publish Event
```

Jangan menghilangkan input user ketika validasi gagal.

------------------------------------------------------------------------

# 27. Admin Ticket Management

Form:

``` text
Ticket Name
Description
Price
Quota
Sales Start
Sales End
```

Contoh:

``` text
Regular
Rp100.000
Quota: 500

VIP
Rp250.000
Quota: 100
```

`available` harus dihitung/dikelola berdasarkan penjualan, bukan
dipercaya dari input user secara bebas.

------------------------------------------------------------------------

# 28. Admin Participants

Table:

``` text
Participant
Event
Ticket
Order
Payment
Check-in
```

Filter:

``` text
Event
Ticket
Payment Status
Check-in Status
```

Check-in status:

``` text
Not Checked In
Checked In
```

------------------------------------------------------------------------

# 29. Admin Transactions

Table:

``` text
Order ID
Member
Event
Amount
Payment Method
Status
Date
```

Status:

``` text
Pending
Paid
Failed
Refunded
```

------------------------------------------------------------------------

# 30. Responsive Design

Breakpoints harus mengikuti Tailwind defaults kecuali ada kebutuhan
khusus.

Prioritas:

## Mobile

-   single column
-   bottom navigation atau compact menu jika diperlukan
-   CTA full width pada context yang sesuai
-   filter menggunakan drawer/modal
-   table dapat menjadi card/list

## Tablet

-   2-column grid
-   compact sidebar/navigation

## Desktop

-   3--4 column event grid
-   full navigation
-   admin sidebar

------------------------------------------------------------------------

# 31. Loading States

Semua data asynchronous harus memiliki loading state.

Contoh:

``` text
Event list → skeleton cards
Dashboard → skeleton stat cards
Table → skeleton rows
```

Jangan menampilkan halaman kosong ketika data sedang dimuat.

------------------------------------------------------------------------

# 32. Empty States

Gunakan empty state untuk:

``` text
No Events
No Tickets
No Transactions
No Participants
No Search Results
```

Setiap empty state harus memiliki:

-   title
-   short explanation
-   optional CTA

Contoh:

``` text
No tickets yet.

You haven't purchased any event tickets.

[Explore Events]
```

------------------------------------------------------------------------

# 33. Error States

Error harus jelas dan actionable.

Contoh:

``` text
Something went wrong.

We couldn't load the events.
Please try again.

[Retry]
```

Form validation:

``` text
Title is required.
```

Jangan menggunakan error message teknis seperti stack trace pada UI
user.

------------------------------------------------------------------------

# 34. Database Design Reference

Database utama:

``` text
users
categories
events
tickets
orders
order_items
payments
event_attendees
```

Relationships:

``` text
User 1:N Orders
Category 1:N Events
Event 1:N Tickets
Order 1:N OrderItems
Ticket 1:N OrderItems
Order 1:N Payments
User 1:N EventAttendees
Event 1:N EventAttendees
Ticket 1:N EventAttendees
Order 1:N EventAttendees
```

------------------------------------------------------------------------

# 35. Status Values

## Event

``` text
draft
published
ongoing
completed
cancelled
```

## Order

``` text
pending
paid
failed
refunded
```

## Payment

``` text
pending
paid
failed
refunded
```

## Attendee

``` text
checked_in = false
checked_in = true
```

------------------------------------------------------------------------

# 36. Naming Convention

Gunakan Laravel conventions.

## Models

``` text
User
Category
Event
Ticket
Order
OrderItem
Payment
EventAttendee
```

## Tables

``` text
users
categories
events
tickets
orders
order_items
payments
event_attendees
```

## Blade Components

``` text
components/button.blade.php
components/input.blade.php
components/event-card.blade.php
components/category-card.blade.php
components/badge.blade.php
```

## Layouts

``` text
layouts/app.blade.php
layouts/public.blade.php
layouts/member.blade.php
layouts/admin.blade.php
```

------------------------------------------------------------------------

# 37. File Organization

Rekomendasi:

``` text
app/
├── Models/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Member/
│   │   └── Public/
│   └── Requests/
├── Policies/
└── Services/

resources/
├── views/
│   ├── layouts/
│   ├── components/
│   ├── public/
│   ├── member/
│   └── admin/
└── css/

routes/
└── web.php

database/
├── migrations/
├── factories/
└── seeders/
```

------------------------------------------------------------------------

# 38. Agent Rules

Coding agent yang mengerjakan EventHub harus mengikuti aturan berikut.

## Rule 1 --- Read First

Sebelum mengubah UI atau struktur fitur:

1.  baca `design.md`
2.  cek struktur project yang sudah ada
3.  cek migration/model/controller yang terkait
4.  gunakan komponen yang sudah ada sebelum membuat komponen baru

## Rule 2 --- Do Not Duplicate

Jangan membuat:

-   button component kedua jika button component sudah ada
-   navbar baru untuk halaman yang menggunakan layout yang sama
-   CSS global yang menduplikasi Tailwind
-   route yang sama dengan nama berbeda tanpa alasan

## Rule 3 --- Preserve Existing Functionality

Saat mengubah UI:

-   jangan merusak route
-   jangan menghapus validation
-   jangan menghapus authorization
-   jangan mengubah database tanpa kebutuhan
-   jangan mengganti dependency tanpa alasan

## Rule 4 --- Role Isolation

Member tidak boleh memperoleh akses Admin hanya karena menu
disembunyikan.

Authorization wajib diterapkan pada server-side.

## Rule 5 --- Responsive

Setiap page baru harus diuji minimal pada:

``` text
Mobile
Tablet
Desktop
```

## Rule 6 --- Reusable Components

Jika UI muncul lebih dari sekali, pertimbangkan reusable component.

## Rule 7 --- No Hardcoded Production Data

Data berikut harus berasal dari backend/database:

-   event
-   category
-   ticket
-   price
-   quota
-   participants
-   transactions
-   dashboard statistics

## Rule 8 --- Preserve Design Tokens

Jangan membuat warna, font, radius, atau spacing baru jika token yang
tersedia sudah mencukupi.

------------------------------------------------------------------------

# 39. MVP Scope

Versi MVP EventHub harus mencakup:

### Public

-   Home
-   Explore
-   Event Detail
-   Login
-   Register

### Member

-   Dashboard
-   Ticket
-   Checkout
-   Transactions
-   Profile

### Admin

-   Dashboard
-   Event CRUD
-   Category CRUD
-   Ticket management
-   Participants
-   Transactions

### System

-   Authentication
-   Role authorization
-   Event status
-   Ticket quota
-   Order
-   Payment status
-   Digital ticket

------------------------------------------------------------------------

# 40. Post-MVP

Fitur berikut tidak wajib untuk MVP:

``` text
Payment Gateway
QR Scanner
Email Notification
Push Notification
Favorites
Reviews
Advanced Analytics
Refund Automation
Organizer Multiple Accounts
Event Recommendation
```

Jangan mengimplementasikan fitur post-MVP sebelum core flow stabil.

------------------------------------------------------------------------

# 41. Core User Flows

## Member

``` text
Home
 ↓
Explore
 ↓
Event Detail
 ↓
Select Ticket
 ↓
Checkout
 ↓
Payment
 ↓
Digital Ticket
 ↓
Check-in
```

## Admin

``` text
Login
 ↓
Dashboard
 ↓
Create Event
 ↓
Create Ticket
 ↓
Publish
 ↓
Monitor Participants
 ↓
Transactions
 ↓
Reports
```

------------------------------------------------------------------------

# 42. Acceptance Criteria --- Public

Home harus:

-   menampilkan branding EventHub
-   memiliki CTA utama
-   memiliki search
-   menampilkan Popular Categories
-   menampilkan event cards
-   responsive

Explore harus:

-   dapat mencari event
-   dapat filter
-   menampilkan result
-   memiliki empty state
-   memiliki pagination jika diperlukan

Event Detail harus:

-   menampilkan informasi event
-   menampilkan ticket options
-   menampilkan availability
-   memiliki CTA yang sesuai status tiket

------------------------------------------------------------------------

# 43. Acceptance Criteria --- Member

Member harus dapat:

1.  register
2.  login
3.  browse event
4.  search/filter event
5.  membuka event detail
6.  memilih ticket
7.  membuat order
8.  melihat status transaksi
9.  melihat digital ticket
10. melihat profile

Member tidak boleh:

-   mengakses admin route
-   mengubah event milik admin
-   melihat data peserta secara global
-   melihat laporan admin

------------------------------------------------------------------------

# 44. Acceptance Criteria --- Admin

Admin harus dapat:

1.  login
2.  melihat dashboard
3.  membuat event
4.  mengedit event
5.  menghapus event
6.  publish event
7.  membuat kategori
8.  membuat ticket
9.  melihat participant
10. melihat transaction
11. melihat member
12. melihat report

Admin route harus dilindungi authorization.

------------------------------------------------------------------------

# 45. Development Order

Implementasikan EventHub dalam urutan berikut:

``` text
1. Laravel setup
2. Environment configuration
3. Database
4. Migrations
5. Models + relationships
6. Seeders/factories
7. Authentication
8. Role + authorization
9. Layout + design system
10. Category CRUD
11. Event CRUD
12. Public Home
13. Explore
14. Event Detail
15. Ticket management
16. Checkout
17. Orders
18. Payments/status
19. Member Dashboard
20. Digital Ticket
21. Admin Dashboard
22. Participants
23. Transactions
24. Reports
25. QR check-in
26. Validation
27. Security
28. Responsive testing
29. UI polish
30. Final testing
```

------------------------------------------------------------------------

# 46. Definition of Done

Sebuah fitur dianggap selesai hanya jika:

-   UI sesuai design system
-   responsive
-   route bekerja
-   authorization benar
-   validation tersedia
-   loading state tersedia jika diperlukan
-   empty state tersedia jika diperlukan
-   error state tersedia jika diperlukan
-   database relation benar
-   tidak ada data production yang hardcoded
-   tidak merusak fitur existing
-   dapat diuji berdasarkan role

------------------------------------------------------------------------

# 47. Final Design Summary

EventHub harus terasa seperti:

``` text
Modern
   +
Simple
   +
Trustworthy
   +
Event-focused
   +
Easy to use
```

Core visual identity:

``` text
Primary: #635BFF
Secondary: #FFB547
Background: #F8F9FC
Surface: #FFFFFF
Text: #171717
Muted: #667085
Font: Poppins
```

Core roles:

``` text
MEMBER → Discover → Book → Attend

ADMIN  → Create → Manage → Monitor
```

Core product flow:

``` text
DISCOVER
   ↓
EVENT
   ↓
TICKET
   ↓
CHECKOUT
   ↓
PAYMENT
   ↓
DIGITAL TICKET
   ↓
CHECK-IN
```

**End of Design Specification**
