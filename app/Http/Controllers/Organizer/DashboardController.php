<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalEvents = Event::ownedBy($userId)->count();
        $draftEvents = Event::ownedBy($userId)->where('status', 'draft')->count();
        $pendingEvents = Event::ownedBy($userId)->where('status', 'pending')->count();
        $publishedEvents = Event::ownedBy($userId)->where('status', 'published')->count();

        $totalRegistrations = Registration::whereHas('event', function ($q) use ($userId) {
            $q->where('organizer_id', $userId);
        })->where('status', 'registered')->count();

        $recentEvents = Event::ownedBy($userId)
            ->with(['category', 'eventType'])
            ->latest()
            ->limit(5)
            ->get();

        return view('organizer.dashboard', compact(
            'totalEvents', 'draftEvents', 'pendingEvents', 'publishedEvents',
            'totalRegistrations', 'recentEvents'
        ));
    }
}
