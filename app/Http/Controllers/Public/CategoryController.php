<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\EventFormat;
use App\Models\EventType;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of active categories with published event count.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['events' => function ($q) {
                $q->where('status', 'published')->where('end_at', '>=', now());
            }])
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category with its filtered published events and pagination.
     */
    public function show(string $slug, Request $request)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->withCount(['events' => function ($q) {
                $q->where('status', 'published')->where('end_at', '>=', now());
            }])
            ->firstOrFail();

        $query = Event::where('category_id', $category->id)
            ->where('status', 'published')
            ->where('end_at', '>=', now())
            ->with(['category', 'city', 'eventType', 'eventFormat', 'organizer']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
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

        $types = EventType::where('is_active', true)->orderBy('name')->get();
        $formats = EventFormat::where('is_active', true)->orderBy('name')->get();
        $cities = City::where('is_active', true)->orderBy('name')->get();

        return view('categories.show', compact('category', 'events', 'types', 'formats', 'cities'));
    }
}
