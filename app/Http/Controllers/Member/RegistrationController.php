<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Notification;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->registrations()
            ->with(['event.category', 'event.city', 'event.eventType']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->orderByDesc('registered_at')->paginate(10)->withQueryString();

        // Stats for sidebar
        $user = auth()->user();
        $totalRegistered = Registration::where('user_id', $user->id)->where('status', 'registered')->count();
        $totalAttended = Registration::where('user_id', $user->id)->where('status', 'attended')->count();
        $totalCancelled = Registration::where('user_id', $user->id)->where('status', 'cancelled')->count();
        $totalPendingPayment = Registration::where('user_id', $user->id)->where('status', 'pending_payment')->count();
        $totalNoShow = Registration::where('user_id', $user->id)->where('status', 'no_show')->count();

        return view('member.registrations.index', compact(
            'registrations', 'totalRegistered', 'totalAttended', 'totalCancelled', 'totalPendingPayment', 'totalNoShow'
        ));
    }

    public function store(Request $request, Event $event)
    {
        // Authorization checks
        if ($event->status !== 'published') {
            return back()->withErrors(['event' => 'Event tidak tersedia untuk registrasi.']);
        }

        if ($event->end_at->isPast()) {
            return back()->withErrors(['event' => 'Event sudah berakhir.']);
        }

        if ($event->registration_deadline && $event->registration_deadline->isPast()) {
            return back()->withErrors(['event' => 'Batas waktu registrasi sudah lewat.']);
        }

        // Check capacity
        if ($event->capacity) {
            $registeredCount = $event->registrations()
                ->where('status', 'registered')
                ->count();
            if ($registeredCount >= $event->capacity) {
                return back()->withErrors(['event' => 'Event sudah penuh.']);
            }
        }

        // Check duplicate
        $existing = Registration::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->where('status', 'registered')
            ->exists();

        if ($existing) {
            return back()->withErrors(['event' => 'Anda sudah terdaftar di event ini.']);
        }

        // Check user restriction
        if (auth()->user()->is_restricted) {
            return back()->withErrors(['event' => 'Akun Anda dibatasi karena melebihi batas no-show. Hubungi admin untuk informasi lebih lanjut.']);
        }

        // Atomic registration: prevent race condition / overbooking
        $registration = DB::transaction(function () use ($event) {
            // Re-check capacity inside transaction with lock
            if ($event->capacity) {
                $registeredCount = $event->registrations()
                    ->where('status', 'registered')
                    ->lockForUpdate()
                    ->count();
                if ($registeredCount >= $event->capacity) {
                    return null;
                }
            }

            // Re-check duplicate inside transaction
            $existing = Registration::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->where('status', 'registered')
                ->exists();

            if ($existing) {
                return 'duplicate';
            }

            // Determine registration status based on payment method
            $status = match($event->payment_method) {
                'upfront' => Registration::STATUS_PENDING_PAYMENT,
                default => Registration::STATUS_REGISTERED,
            };

            // Create registration
            return Registration::create([
                'event_id' => $event->id,
                'user_id' => auth()->id(),
                'registration_code' => 'REG-' . Str::upper(Str::random(8)),
                'status' => $status,
                'registered_at' => now(),
            ]);
        });

        // Handle transaction results
        if ($registration === null) {
            return back()->withErrors(['event' => 'Event sudah penuh.']);
        }
        if ($registration === 'duplicate') {
            return back()->withErrors(['event' => 'Anda sudah terdaftar di event ini.']);
        }

        // Send notification to member
        Notification::createFor(
            auth()->id(),
            'registration_success',
            'Registrasi Berhasil',
            'Anda berhasil terdaftar di event "' . $event->title . '".',
            route('member.registrations')
        );

        $message = $event->payment_method === 'upfront'
            ? 'Registrasi berhasil! Silakan lakukan pembayaran sesuai info yang tertera.'
            : 'Berhasil mendaftar di event "' . $event->title . '"!';

        return back()->with('success', $message);
    }

    public function destroy(Registration $registration)
    {
        // Only owner can cancel
        if ($registration->user_id !== auth()->id()) {
            abort(403);
        }

        if ($registration->status !== Registration::STATUS_REGISTERED) {
            return back()->withErrors(['registration' => 'Registrasi ini sudah dibatalkan.']);
        }

        // Cannot cancel after event starts
        if ($registration->event->start_at->isPast()) {
            return back()->withErrors(['registration' => 'Tidak bisa membatalkan registrasi setelah event dimulai.']);
        }

        $registration->update([
            'status' => Registration::STATUS_CANCELLED,
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Registrasi berhasil dibatalkan.');
    }
}
