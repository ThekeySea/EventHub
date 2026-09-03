<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\Registration;
use App\Models\EventFormat;
use App\Models\EventType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $query = Event::ownedBy(Auth::id())->with(['category', 'organizer']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(10);
        $statuses = ['draft' => 'Draf', 'pending' => 'Pending', 'published' => 'Dipublikasikan', 'rejected' => 'Ditolak', 'cancelled' => 'Dibatalkan', 'completed' => 'Selesai'];

        return view('organizer.events.index', compact('events', 'statuses'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        $eventTypes = EventType::where('is_active', true)->get();
        $formats = EventFormat::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();
        return view('organizer.events.create', compact('categories', 'eventTypes', 'formats', 'cities'));
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $data['organizer_id'] = Auth::id();
        $data['status'] = 'draft';

        // Handle banner upload
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $event = Event::create($data);

        return Redirect::route('organizer.events.edit', $event)
            ->with('success', 'Event berhasil dibuat dan disimpan sebagai draft.');
    }

    public function show(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['category', 'eventType', 'eventFormat', 'city', 'registrations' => function ($q) {
            $q->with('user')->orderByDesc('registered_at');
        }]);

        $registeredCount = $event->registrations()->where('status', 'registered')->count();
        $slotsRemaining = $event->capacity ? $event->capacity - $registeredCount : null;

        return view('organizer.events.show', compact('event', 'registeredCount', 'slotsRemaining'));
    }

    public function edit(Event $event): View
    {
        $this->authorize('view', $event);
        $categories = Category::where('is_active', true)->get();
        $eventTypes = EventType::where('is_active', true)->get();
        $formats = EventFormat::where('is_active', true)->get();
        $cities = City::where('is_active', true)->get();
        return view('organizer.events.edit', compact('event', 'categories', 'eventTypes', 'formats', 'cities'));
    }

        public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        $data = $request->validated();

        // Handle banner upload — only update if a new file is uploaded
        if ($request->hasFile('banner')) {
            if ($event->banner) {
                Storage::disk('public')->delete($event->banner);
            }
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // Check if this is a published event being edited
        $isPublishedEdit = $event->status === 'published';
        
        // Substantial fields that require re-moderation when changed
        $substantialFields = ['title', 'description', 'category_id', 'event_type_id', 'event_format_id', 
                              'city_id', 'start_at', 'end_at', 'capacity', 'location', 'online_url'];
        
        $hasSubstantialChanges = false;
        if ($isPublishedEdit) {
            foreach ($substantialFields as $field) {
                if (isset($data[$field]) && $data[$field] != $event->$field) {
                    $hasSubstantialChanges = true;
                    break;
                }
            }
            // Also check banner
            if ($request->hasFile('banner')) {
                $hasSubstantialChanges = true;
            }
        }

        // Handle submit for review
        if ($request->has('submit_type') && $request->submit_type === 'submit') {
            $data['status'] = 'pending';
            $data['rejection_reason'] = null;
        } elseif ($isPublishedEdit && $hasSubstantialChanges) {
            // Published event with substantial changes → return to pending
            $data['status'] = 'pending';
            $data['rejection_reason'] = null;
        }

        $event->update($data);

        // Determine success message
        if ($request->has('submit_type') && $request->submit_type === 'submit') {
            return Redirect::route('organizer.events.index')
                ->with('success', 'Event berhasil dikirim untuk review.');
        } elseif ($isPublishedEdit && $hasSubstantialChanges) {
            return Redirect::route('organizer.events.edit', $event)
                ->with('success', 'Perubahan substantif terdeteksi. Event telah dikembalikan ke status pending untuk review ulang oleh admin.');
        }

        return Redirect::route('organizer.events.edit', $event)
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function submit(Event $event): RedirectResponse
    {
        $this->authorize('submit', $event);

        $event->update([
            'status' => 'pending',
            'rejection_reason' => null,
        ]);

        return Redirect::route('organizer.events.index')
            ->with('success', 'Event berhasil dikirim untuk review.');
    }

    public function cancel(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        if (!in_array($event->status, ['draft', 'pending', 'published'])) {
            return back()->withErrors(['event' => 'Event dengan status ini tidak bisa dibatalkan.']);
        }

        $event->update(['status' => 'cancelled']);

        return Redirect::route('organizer.events.index')
            ->with('success', 'Event "' . $event->title . '" telah dibatalkan.');
    }
    public function clone(Event $event): RedirectResponse
    {
        $this->authorize('view', $event);

        // Clone the event with new title and draft status
        $newEvent = $event->replicate();
        $newEvent->title = 'Salinan dari ' . $event->title;
        $newEvent->status = 'draft';
        // Generate unique slug
        $baseSlug = \Illuminate\Support\Str::slug('salinan-' . $event->slug);
        $slug = $baseSlug;
        $counter = 1;
        while (\App\Models\Event::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }
        $newEvent->slug = $slug;
        $newEvent->rejection_reason = null;
        $newEvent->start_at = $event->start_at;
        $newEvent->end_at = $event->end_at;
        $newEvent->registration_deadline = $event->registration_deadline;
        $newEvent->save();

        return Redirect::route('organizer.events.edit', $newEvent)
            ->with('success', 'Event berhasil diduplikasi. Silakan edit sesuai kebutuhan.');
    }
    public function analytics(Event $event): View
    {
        $this->authorize('view', $event);

        $event->load(['category', 'eventType', 'eventFormat', 'city']);

        // Basic stats
        $totalRegistered = $event->registrations()->where('status', 'registered')->count();
        $totalPendingPayment = $event->registrations()->where('status', 'pending_payment')->count();
        $totalAttended = $event->registrations()->where('status', 'attended')->count();
        $totalCancelled = $event->registrations()->where('status', 'cancelled')->count();
        $totalNoShow = $event->registrations()->where('status', 'no_show')->count();
        $totalWaitlisted = $event->registrations()->where('status', 'waitlisted')->count();
        $capacity = $event->capacity;
        $capacityUsed = $capacity ? round(($totalRegistered / $capacity) * 100) : 0;

        // Payment method label (from event, not registration)
        $paymentLabel = match($event->payment_method) {
            'upfront' => 'Bayar di Muka',
            'onsite' => 'Bayar di Tempat',
            default => 'Gratis',
        };

        // Registration period — from first registration to last registration (or today)
        $firstRegDate = $event->registrations()->min('created_at');
        $lastRegDate = $event->registrations()->max('created_at');
        
        if ($firstRegDate && $lastRegDate) {
            $startDate = \Carbon\Carbon::parse($firstRegDate)->startOfDay();
            $endDate = \Carbon\Carbon::parse($lastRegDate)->endOfDay();
            // Ensure minimum 3 days display
            if ($startDate->diffInDays($endDate) < 2) {
                $endDate = $startDate->copy()->addDays(2)->endOfDay();
            }
        } else {
            // No registrations yet — show last 7 days
            $startDate = now()->subDays(6)->startOfDay();
            $endDate = now()->endOfDay();
        }
        
        // Limit to max 30 days to prevent huge charts
        if ($startDate->diffInDays($endDate) > 29) {
            $startDate = $endDate->copy()->subDays(29)->startOfDay();
        }

        $dailyRegs = [];
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            $dailyRegs[] = [
                'date' => $current->format('d M'),
                'count' => $event->registrations()->whereDate('created_at', $current->toDateString())->count(),
            ];
            $current->addDay();
        }
        $maxDaily = max(array_column($dailyRegs, 'count')) ?: 1;

        return view('organizer.events.analytics', compact(
            'event', 'totalRegistered', 'totalPendingPayment', 'totalAttended',
            'totalCancelled', 'totalNoShow', 'totalWaitlisted',
            'capacity', 'capacityUsed', 'paymentLabel',
            'dailyRegs', 'maxDaily'
        ));
    }

    public function communicate(Request $request, Event $event)
    {
        $this->authorize('view', $event);

        $request->validate([
            'message' => 'required|string|max:1000',
            'subject' => 'required|string|max:255',
        ]);

        // Get all active registrations for this event
        $registrations = $event->registrations()
            ->whereIn('status', ['registered', 'pending_payment'])
            ->get();

        foreach ($registrations as $reg) {
            \App\Models\Notification::createFor(
                $reg->user_id,
                'event_reminder',
                $request->subject,
                $request->message . ' — Event: ' . $event->title,
                route('events.show', $event->slug)
            );
        }

        return back()->with('success', 'Pengumuman berhasil dikirim ke ' . $registrations->count() . ' pendaftar.');
    }

    public function registrations(Event $event): View
    {
        $this->authorize('view', $event);

        $registrations = $event->registrations()
            ->with('user')
            ->orderByDesc('registered_at')
            ->paginate(15);

        return view('organizer.events.registrations', compact('event', 'registrations'));
    }

    public function registrationDetail(Event $event, Registration $registration): View
    {
        $this->authorize('view', $event);

        if ($registration->event_id !== $event->id) {
            abort(404);
        }

        $registration->load(['user', 'logs']);

        return view('organizer.events.registration-detail', compact('event', 'registration'));
    }

    public function checkin(Event $event, Registration $registration)
    {
        $this->authorize('view', $event);

        if ($registration->event_id !== $event->id) {
            return back()->with('error', 'Registrasi bukan milik event ini.');
        }

        $action = request('action');

        if ($action === 'checkin') {
            $registration->checkIn();
            return back()->with('success', $registration->user->name . ' telah ditandai hadir.');
        } elseif ($action === 'noshow') {
            $registration->markNoShow();
            return back()->with('success', $registration->user->name . ' telah ditandai tidak hadir (no-show).');
        }

        return back()->with('error', 'Aksi tidak valid.');
    }

    public function confirmPayment(Event $event, Registration $registration)
    {
        $this->authorize('view', $event);

        if ($registration->event_id !== $event->id) {
            return back()->with('error', 'Registrasi bukan milik event ini.');
        }

        if ($registration->status !== Registration::STATUS_PENDING_PAYMENT) {
            return back()->with('error', 'Registrasi tidak dalam status menunggu pembayaran.');
        }

        $registration->confirmPayment();

        return back()->with('success', 'Pembayaran ' . $registration->user->name . ' telah dikonfirmasi.');
    }

    public function exportRegistrations(Event $event)
    {
        $registrations = \App\Models\Registration::where('event_id', $event->id)
            ->with('user')
            ->get();

        $callback = function () use ($registrations, $event) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode', 'Nama', 'Email', 'Status', 'Tanggal Daftar', 'Check-in', 'Konfirmasi Bayar']);
            foreach ($registrations as $reg) {
                fputcsv($file, [$reg->registration_code, $reg->user->name ?? '-', $reg->user->email ?? '-', $reg->status, $reg->registered_at ? $reg->registered_at->format('d M Y H:i') : '-', $reg->checked_in_at ? 'Ya' : 'Tidak', $reg->payment_confirmed_at ? 'Ya' : ($event->payment_method === 'free' ? 'N/A' : 'Belum')]);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="pendaftar-' . $event->slug . '.csv"']);
    }
}