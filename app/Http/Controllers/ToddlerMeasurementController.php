<?php

namespace App\Http\Controllers;

use App\Models\ToddlerMeasurement;
use App\Models\Schedule;
use App\Models\Toddler;
use App\Http\Requests\StoreToddlerMeasurementRequest;
use Illuminate\Http\Request;

class ToddlerMeasurementController extends Controller
{
    /**
     * Show the form for creating a new measurement.
     */
    public function create(Schedule $schedule, Toddler $toddler)
    {
        return view('measurements.toddler-create', compact('schedule', 'toddler'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToddlerMeasurementRequest $request)
    {
        ToddlerMeasurement::create($request->validated());

        return redirect()->route('schedules.show', $request->schedule_id)
            ->with('success', 'Pengukuran balita berhasil dicatat.');
    }
}
