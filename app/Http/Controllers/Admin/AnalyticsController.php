<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Grafik 1: User aktif per minggu (8 minggu terakhir)
        $weeks = collect();
        for ($i = 7; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $weeks->push([
                'label' => $start->format('d M'),
                'count' => User::where('created_at', '>=', $start)
                    ->where('created_at', '<=', $end)
                    ->count(),
            ]);
        }

        // Grafik 2: Event per bulan per status (6 bulan terakhir)
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months->push([
                'label' => $month->format('M Y'),
                'published' => Event::where('status', 'published')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'pending' => Event::where('status', 'pending')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
                'draft' => Event::where('status', 'draft')
                    ->whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ]);
        }

        // Grafik 3: Trend registrasi per minggu (8 minggu terakhir)
        $regWeeks = collect();
        for ($i = 7; $i >= 0; $i--) {
            $start = Carbon::now()->subWeeks($i)->startOfWeek();
            $end = Carbon::now()->subWeeks($i)->endOfWeek();
            $regWeeks->push([
                'label' => $start->format('d M'),
                'count' => Registration::where('registered_at', '>=', $start)
                    ->where('registered_at', '<=', $end)
                    ->count(),
            ]);
        }

        // Summary stats
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalRegistrations = Registration::count();
        $activeUsers = User::where('status', 'active')->count();

        return view('admin.analytics.index', compact(
            'weeks', 'months', 'regWeeks',
            'totalUsers', 'totalEvents', 'totalRegistrations', 'activeUsers'
        ));
    }
}
