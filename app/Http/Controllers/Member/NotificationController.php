<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::forUser(auth()->id())
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $unreadCount = Notification::forUser(auth()->id())->unread()->count();

        // Determine view based on user role
        $view = match(auth()->user()->role) {
            'admin' => 'admin.notifications.index',
            'organizer' => 'organizer.notifications.index',
            default => 'member.notifications.index',
        };
        
        return view($view, compact('notifications', 'unreadCount'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Notification::forUser(auth()->id())->unread()->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notifikasi dihapus.');
    }
}
