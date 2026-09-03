<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Stats
        $totalRegistrations = Registration::where('user_id', $user->id)
            ->where('status', 'registered')
            ->count();

        $totalFavorites = $user->favorites()->count();

        $totalAttended = Registration::where('user_id', $user->id)
            ->where('status', 'attended')
            ->count();

        // Upcoming events (registrations where event hasn't started yet)
        $upcomingRegistrations = Registration::where('user_id', $user->id)
            ->where('status', 'registered')
            ->whereHas('event', function ($q) {
                $q->where('start_at', '>=', now());
            })
            ->with(['event.category', 'event.city', 'event.eventType'])
            ->orderBy('registered_at', 'desc')
            ->limit(5)
            ->get();

        // Recent favorites
        $recentFavorites = $user->favorites()
            ->with(['event.category', 'event.eventType'])
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        // Event history (past registrations)
        $pastRegistrations = Registration::where('user_id', $user->id)
            ->whereHas('event', function ($q) {
                $q->where('end_at', '<', now());
            })
            ->with(['event.category', 'event.city'])
            ->orderBy('registered_at', 'desc')
            ->limit(5)
            ->get();

        return view('member.dashboard', compact(
            'totalRegistrations',
            'totalFavorites',
            'totalAttended',
            'upcomingRegistrations',
            'recentFavorites',
            'pastRegistrations'
        ));
    }
}
