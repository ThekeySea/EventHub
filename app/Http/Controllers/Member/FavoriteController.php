<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with(['event.category', 'event.city', 'event.eventType', 'event.eventFormat'])
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('member.favorites.index', compact('favorites'));
    }

    public function store(Request $request, Event $event)
    {
        // Check event is published
        if ($event->status !== 'published') {
            return back()->withErrors(['event' => 'Hanya event published yang bisa difavoritkan.']);
        }

        // Check duplicate
        $exists = Favorite::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Event sudah ada di favorit Anda.');
        }

        Favorite::create([
            'user_id' => auth()->id(),
            'event_id' => $event->id,
        ]);

        return back()->with('success', 'Event ditambahkan ke favorit!');
    }

    public function destroy(Event $event)
    {
        Favorite::where('user_id', auth()->id())
            ->where('event_id', $event->id)
            ->delete();

        return back()->with('success', 'Event dihapus dari favorit.');
    }
}
