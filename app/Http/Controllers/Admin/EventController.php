<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\AuditLog;
use App\Models\Notification;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with(['organizer', 'category', 'eventType', 'city']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhereHas('organizer', fn ($sub) => $sub->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->latest()->paginate(15);
        $statuses = ['draft' => 'Draf', 'pending' => 'Pending', 'published' => 'Dipublikasikan', 'rejected' => 'Ditolak', 'cancelled' => 'Dibatalkan', 'completed' => 'Selesai'];

        return view('admin.events.index', compact('events', 'statuses'));
    }

    public function pending(Request $request)
    {
        $query = Event::with(['organizer', 'category', 'eventType', 'city'])
            ->where('status', 'pending');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->latest()->paginate(15);

        return view('admin.events.pending', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['organizer', 'category', 'eventType', 'eventFormat', 'city']);
        return view('admin.events.show', compact('event'));
    }

    public function approve(Event $event)
    {
        if ($event->status !== 'pending') {
            return back()->with('error', 'Hanya event pending yang dapat disetujui.');
        }

        $event->update([
            'status' => 'published',
            'rejection_reason' => null,
        ]);

        // Send notification to organizer
        Notification::createFor(
            $event->organizer_id,
            'event_approved',
            'Event Disetujui',
            'Event "' . $event->title . '" telah disetujui dan dipublikasikan.',
            route('organizer.events.show', $event)
        );

        return back()->with('success', 'Event "' . $event->title . '" telah disetujui dan dipublikasikan.');
    }

    public function reject(Request $request, Event $event)
    {
        if ($event->status !== 'pending') {
            return back()->with('error', 'Hanya event pending yang dapat ditolak.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $event->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Send notification to organizer
        Notification::createFor(
            $event->organizer_id,
            'event_rejected',
            'Event Ditolak',
            'Event "' . $event->title . '" ditolak. Alasan: ' . $request->rejection_reason,
            route('organizer.events.show', $event)
        );

        return back()->with('success', 'Event "' . $event->title . '" telah ditolak.');
    }

    public function destroy(Request $request, Event $event)
    {
        $request->validate([
            'delete_reason' => 'required|string|max:1000',
        ]);

        $event->update([
            'status' => 'cancelled',
            'rejection_reason' => $request->delete_reason,
        ]);

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event "' . $event->title . '" telah dihapus.');
    }
}
