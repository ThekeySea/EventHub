<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventType;
use App\Http\Requests\StoreEventTypeRequest;
use App\Http\Requests\UpdateEventTypeRequest;
use Illuminate\Http\Request;

class EventTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = EventType::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('slug', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $eventTypes = $query->latest()->paginate(10);
        return view('admin.event-types.index', compact('eventTypes'));
    }

    public function create()
    {
        return view('admin.event-types.create');
    }

    public function store(StoreEventTypeRequest $request)
    {
        EventType::create($request->validated());
        return redirect()->route('admin.event-types.index')->with('success', 'Jenis acara berhasil dibuat.');
    }

    public function edit(EventType $eventType)
    {
        return view('admin.event-types.edit', compact('eventType'));
    }

    public function update(UpdateEventTypeRequest $request, EventType $eventType)
    {
        $eventType->update($request->validated());
        return redirect()->route('admin.event-types.index')->with('success', 'Jenis acara berhasil diperbarui.');
    }

    public function toggleStatus(EventType $eventType)
    {
        $eventType->update(['is_active' => !$eventType->is_active]);
        return back()->with('success', 'Status jenis acara berhasil diperbarui.');
    }
}
