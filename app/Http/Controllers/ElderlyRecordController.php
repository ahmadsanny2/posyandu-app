<?php

namespace App\Http\Controllers;

use App\Models\ElderlyRecord;
use App\Models\Schedule;
use App\Models\Elderly;
use App\Http\Requests\StoreElderlyRecordRequest;
use Illuminate\Http\Request;

class ElderlyRecordController extends Controller
{
    /**
     * Show the form for creating a new elderly record.
     */
    public function create(Schedule $schedule, Elderly $elderly)
    {
        return view('measurements.elderly-create', compact('schedule', 'elderly'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreElderlyRecordRequest $request)
    {
        ElderlyRecord::create($request->validated());

        return redirect()->route('schedules.show', $request->schedule_id)
            ->with('success', 'Rekam medis lansia berhasil dicatat.');
    }
}
