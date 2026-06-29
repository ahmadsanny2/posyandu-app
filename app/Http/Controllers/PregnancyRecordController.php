<?php

namespace App\Http\Controllers;

use App\Models\PregnancyRecord;
use App\Models\Schedule;
use App\Models\PregnantWoman;
use App\Http\Requests\StorePregnancyRecordRequest;
use Illuminate\Http\Request;

class PregnancyRecordController extends Controller
{
    /**
     * Show the form for creating a new pregnancy record.
     */
    public function create(Schedule $schedule, PregnantWoman $pregnantWoman)
    {
        return view('measurements.pregnancy-create', compact('schedule', 'pregnantWoman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePregnancyRecordRequest $request)
    {
        PregnancyRecord::create($request->validated());

        return redirect()->route('schedules.show', $request->schedule_id)
            ->with('success', 'Rekam medis kehamilan berhasil dicatat.');
    }
}
