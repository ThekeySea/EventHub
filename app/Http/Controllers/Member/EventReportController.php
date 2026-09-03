<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventReport;
use Illuminate\Http\Request;

class EventReportController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'reason' => 'required|string|in:spam,inappropriate,scam,misleading,other',
            'description' => 'nullable|string|max:1000',
        ]);

        // Check if user already reported this event
        $existing = EventReport::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('info', 'Anda sudah melaporkan event ini sebelumnya.');
        }

        EventReport::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Laporan berhasil dikirim. Terima kasih!');
    }
}
