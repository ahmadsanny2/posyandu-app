<?php

namespace App\Http\Controllers;

use App\Models\Toddler;
use App\Models\PregnantWoman;
use App\Models\Elderly;
use App\Models\ToddlerMeasurement;
use App\Models\PregnancyRecord;
use App\Models\ElderlyRecord;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display report filters page.
     */
    public function index()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isKader() && !auth()->user()->isPuskesmas()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Admin, Kader, atau Puskesmas.');
        }

        // Get months/years from existing records to populate filter dropdowns
        $years = range(now()->year - 2, now()->year);
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('reports.index', compact('months', 'years'));
    }

    /**
     * Render the report in a printer-friendly layout.
     */
    public function print(Request $request)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isKader() && !auth()->user()->isPuskesmas()) {
            abort(403, 'Halaman ini hanya dapat diakses oleh Admin, Kader, atau Puskesmas.');
        }

        $request->validate([
            'report_type' => 'required|in:toddler,pregnant_woman,elderly',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);

        $reportType = $request->report_type;
        $month = $request->month;
        $year = $request->year;

        $monthName = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ][$month];

        $records = [];
        if ($reportType === 'toddler') {
            $records = ToddlerMeasurement::with(['toddler', 'schedule'])
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($reportType === 'pregnant_woman') {
            $records = PregnancyRecord::with(['pregnantWoman', 'schedule'])
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($reportType === 'elderly') {
            $records = ElderlyRecord::with(['elderly', 'schedule'])
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('reports.print', compact('records', 'reportType', 'monthName', 'year'));
    }
}
