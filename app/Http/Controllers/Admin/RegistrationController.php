<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of all event registrations with filters and pagination.
     */
    public function index(Request $request)
    {
        $query = Registration::with([
            'user',
            'event.category',
            'event.city',
            'event.eventType',
        ]);

        // Search by registration code, user name/email, or event title
        $search = $request->input('search', $request->input('q'));
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('registration_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('event', function ($eq) use ($search) {
                        $eq->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status (registered, cancelled, attended)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by specific event
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }

        // Filter by date range (registered_at)
        if ($request->filled('date_from')) {
            $query->whereDate('registered_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('registered_at', '<=', $request->date_to);
        }

        $registrations = $query->latest('registered_at')->paginate(20)->withQueryString();
        $events = Event::orderBy('title')->get(['id', 'title']);

        return view('admin.registrations.index', compact('registrations', 'events'));
    }
}
