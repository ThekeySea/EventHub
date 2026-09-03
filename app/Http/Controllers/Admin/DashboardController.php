<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEvents = Event::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $pendingEvents = Event::where('status', 'pending')->count();
        $publishedEvents = Event::where('status', 'published')->count();

        $recentEvents = Event::with(['organizer', 'category'])
            ->latest()
            ->limit(5)
            ->get();

        $pendingEventsList = Event::with(['organizer', 'category'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvents',
            'totalUsers',
            'totalCategories',
            'pendingEvents',
            'publishedEvents',
            'recentEvents',
            'pendingEventsList'
        ));
    }

    public function organizerPerformance()
    {
        $organizers = User::where('role', 'organizer')
            ->withCount('organizedEvents')
            ->get()
            ->map(function ($organizer) {
                $events = $organizer->organizedEvents;
                $totalEvents = $events->count();
                $publishedEvents = $events->where('status', 'published')->count();
                $publishRate = $totalEvents > 0 ? round(($publishedEvents / $totalEvents) * 100) : 0;

                $totalRegistrations = Registration::whereHas('event', function ($q) use ($organizer) {
                    $q->where('organizer_id', $organizer->id);
                })->count();

                $avgRegistrations = $publishedEvents > 0 ? round($totalRegistrations / $publishedEvents) : 0;

                $totalNoShow = Registration::whereHas('event', function ($q) use ($organizer) {
                    $q->where('organizer_id', $organizer->id);
                })->where('status', 'no_show')->count();

                $noShowRate = $totalRegistrations > 0 ? round(($totalNoShow / $totalRegistrations) * 100) : 0;

                $organizer->total_events = $totalEvents;
                $organizer->published_events = $publishedEvents;
                $organizer->publish_rate = $publishRate;
                $organizer->total_registrations = $totalRegistrations;
                $organizer->avg_registrations = $avgRegistrations;
                $organizer->no_show_rate = $noShowRate;
                $organizer->is_problematic = $noShowRate > 30 && $totalRegistrations > 5;

                return $organizer;
            });

        return view('admin.organizers.index', compact('organizers'));
    }
}
