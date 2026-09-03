# Prompt Antigravity — Backend: About Page + Event Teratas Query

## PROJECT: EventHub (Laravel)

---

## TUGAS 1: ROUTE UNTUK HALAMAN TENTANG KAMI

File: routes/web.php

Tambahkan route public BARU di section public routes:

Route::get('/about', function () {
    return view('about');
})->name('about');

---

## TUGAS 2: CONTROLLER EVENT TERATAS

File: app/Http/Controllers/Public/EventController.php

Tambahkan method baru `topEvents()`:

public function topEvents()
{
    return Event::where('status', 'published')
        ->where('end_at', '>=', now())
        ->withCount(['favorites', 'registrations'])
        ->orderByRaw('favorites_count + registrations_count DESC')
        ->limit(3)
        ->get();
}


Update method `home()` — hapus query `$featuredEvents` dan `$favoritedEvents`.
Ganti dengan:
    $topEvents = Event::where('status', 'published')
        ->where('end_at', '>=', now())
        ->with(['category', 'eventType', 'city'])
        ->withCount(['favorites', 'registrations'])
        ->orderByRaw('favorites_count + registrations_count DESC')
        ->limit(3)
        ->get();

Hapus compact 'featuredEvents' dan 'favoritedEvents'.
Tambahkan 'topEvents' ke compact.

---

## TUGAS 3: SEEDER TESTIMONI

JANGAN buat model atau migration baru.
Testimoni akan di-hardcode di view sebagai array 10 komentar member.

---

## VERIFIKASI

php artisan route:list | grep about
php artisan test

JANGAN ubah view, hanya route + controller.