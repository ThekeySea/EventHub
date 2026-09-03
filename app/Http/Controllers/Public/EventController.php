<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\EventFormat;
use App\Models\EventType;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function home()
    {
        // Tema Populer: 6 kategori dengan event published terbanyak
        $popularThemes = Category::withCount(['events' => function ($q) {
            $q->where('status', 'published')->where('end_at', '>=', now());
        }])
            ->where('is_active', true)
            ->orderByDesc('events_count')
            ->limit(6)
            ->get();

        // Event Teratas: 3 event dengan favorit + registrasi terbanyak
        $topEvents = Event::with(['category', 'eventType', 'city'])
            ->withCount(['favorites', 'registrations'])
            ->where('status', 'published')
            ->where('end_at', '>=', now())
            ->orderByRaw('(COALESCE(favorites_count, 0) + COALESCE(registrations_count, 0)) DESC')
            ->limit(3)
            ->get();

        // Terbaru: 6 event terbaru
        $latestEvents = Event::with(['category', 'eventType', 'city'])
            ->where('status', 'published')
            ->where('end_at', '>=', now())
            ->latest()
            ->limit(6)
            ->get();

        // Event Types untuk Pilihan Acara
        $eventTypes = EventType::where('is_active', true)->get();

        // Filter data untuk search bar
        $themes = Category::where('is_active', true)->orderBy('name')->get();
        $formats = EventFormat::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('welcome', compact(
            'popularThemes',
            'topEvents',
            'latestEvents',
            'eventTypes',
            'themes',
            'formats',
            'cities'
        ));
    }

    public function calendar()
    {
        $calendarEvents = Event::where('status', 'published')
            ->where('start_at', '>=', now())
            ->with('category')
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'title' => $e->title,
                'slug' => $e->slug,
                'start_at' => $e->start_at->toIso8601String(),
                'category' => $e->category->name ?? 'Event',
            ]);

        $upcomingEvents = Event::where('status', 'published')
            ->where('start_at', '>=', now())
            ->with('category')
            ->orderBy('start_at')
            ->limit(9)
            ->get();

        return view('events.calendar', compact('calendarEvents', 'upcomingEvents'));
    }

    public function explore(Request $request)
    {
        $query = Event::where('status', 'published')
            ->where('end_at', '>=', now())
            ->with(['category', 'city', 'eventType', 'eventFormat']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('type')) {
            $query->whereHas('eventType', fn ($q) => $q->where('slug', $request->type));
        }

        if ($request->filled('format')) {
            $query->whereHas('eventFormat', fn ($q) => $q->where('slug', $request->format));
        }

        if ($request->filled('city')) {
            $query->whereHas('city', fn ($q) => $q->where('slug', $request->city));
        }

        if ($request->filled('date_from')) {
            $query->where('start_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('start_at', '<=', $request->date_to);
        }

        $sort = $request->input('sort', 'soonest');
        if ($sort === 'newest') {
            $query->orderByDesc('created_at');
        } else {
            $query->orderBy('start_at', 'asc');
        }

        $events = $query->paginate(12)->withQueryString();

        $themes = Category::where('is_active', true)->get();
        $types = EventType::where('is_active', true)->get();
        $formats = EventFormat::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();

        return view('events.index', compact('events', 'themes', 'types', 'formats', 'cities'));
    }

    public function show(string $slug)
    {
        $event = Event::with(['category', 'city', 'eventType', 'eventFormat', 'organizer'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $slotsRemaining = null;
        if ($event->capacity) {
            $registeredCount = $event->registrations()
                ->where('status', 'registered')
                ->count();
            $slotsRemaining = $event->capacity - $registeredCount;
        }

        $isFavorited = false;
        $myRegistration = null;
        if (auth()->check()) {
            $isFavorited = Favorite::where('user_id', auth()->id())
                ->where('event_id', $event->id)
                ->exists();
            $myRegistration = $event->registrations()
                ->where('user_id', auth()->id())
                ->where('status', 'registered')
                ->first();
        }

        $canRegister = auth()->check()
            && $event->status === 'published'
            && $event->end_at->isFuture()
            && !$myRegistration
            && ($slotsRemaining === null || $slotsRemaining > 0)
            && (!$event->registration_deadline || $event->registration_deadline->isFuture());

        return view('events.show', compact('event', 'slotsRemaining', 'isFavorited', 'myRegistration', 'canRegister'));
    }
}
