<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Attendance;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::query();

        // Search by title or location
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by target type
        if ($request->has('target_type') && $request->target_type != '') {
            $query->where('target_type', $request->target_type);
        }

        // Get schedules
        $schedules = $query->orderBy('scheduled_at', 'desc')->paginate(10)->withQueryString();

        // If user is parent, get their RSVPs for these schedules to display the state in UI
        $userRsvps = [];
        if ($request->user()->isParent()) {
            $userRsvps = Attendance::where('user_id', $request->user()->id)
                ->whereIn('schedule_id', $schedules->pluck('id'))
                ->get()
                ->keyBy('schedule_id');
        }

        return view('schedules.index', compact('schedules', 'userRsvps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Schedule::class); // Let's check permissions
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        Gate::authorize('create', Schedule::class);

        Schedule::create($request->validated());

        return redirect()->route('schedules.index')->with('success', 'Jadwal kegiatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return redirect()->route('schedules.index')->with('success', 'Jadwal kegiatan berhasil diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        // Fetch RSVPs (attendances) for this schedule
        $attendances = $schedule->attendances()->with('user')->get();

        // Get participants list based on target type
        $participants = [];
        $existingMeasurementIds = [];
        
        if ($schedule->target_type === 'toddler') {
            $participants = \App\Models\Toddler::with('user')->get();
            $existingMeasurementIds = $schedule->toddlerMeasurements()->pluck('toddler_id')->toArray();
        } elseif ($schedule->target_type === 'pregnant_woman') {
            $participants = \App\Models\PregnantWoman::with('user')->get();
            $existingMeasurementIds = $schedule->pregnancyRecords()->pluck('pregnant_woman_id')->toArray();
        } elseif ($schedule->target_type === 'elderly') {
            $participants = \App\Models\Elderly::with('user')->get();
            $existingMeasurementIds = $schedule->elderlyRecords()->pluck('elderly_id')->toArray();
        }

        return view('schedules.show', compact('schedule', 'attendances', 'participants', 'existingMeasurementIds'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal kegiatan berhasil dihapus.');
    }

    /**
     * Handle RSVP submission for Parents.
     */
    public function rsvp(Request $request, Schedule $schedule)
    {
        $request->validate([
            'is_present' => 'required|boolean',
            'notes' => 'nullable|string|max:255',
        ]);

        Attendance::updateOrCreate(
            [
                'schedule_id' => $schedule->id,
                'user_id' => $request->user()->id,
            ],
            [
                'is_present' => $request->is_present,
                'notes' => $request->notes,
            ]
        );

        return redirect()->back()->with('success', 'RSVP kehadiran Anda berhasil disimpan.');
    }
}
