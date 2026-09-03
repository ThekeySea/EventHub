<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventReport;
use App\Models\AuditLog;
use App\Models\Notification;
use Illuminate\Http\Request;

class EventReportController extends Controller
{
    public function index(Request $request)
    {
        $query = EventReport::with(['event', 'user', 'reviewer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()->paginate(15)->withQueryString();
        $pendingCount = EventReport::where('status', 'pending')->count();

        return view('admin.reports.index', compact('reports', 'pendingCount'));
    }

    public function show(EventReport $report)
    {
        $report->load(['event', 'user', 'reviewer']);
        return view('admin.reports.show', compact('report'));
    }

    public function resolve(Request $request, EventReport $report)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $report->resolve($request->admin_notes ?? '', auth()->id());

        // Log the action
        AuditLog::log('report_resolved', $report->event, null, [
            'report_id' => $report->id,
            'reason' => $report->reason,
        ], $request);

        return back()->with('success', 'Laporan telah diselesaikan.');
    }

    public function dismiss(Request $request, EventReport $report)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $report->dismiss($request->admin_notes ?? '', auth()->id());

        // Log the action
        AuditLog::log('report_dismissed', $report->event, null, [
            'report_id' => $report->id,
            'reason' => $report->reason,
        ], $request);

        return back()->with('success', 'Laporan telah ditolak.');
    }
}
