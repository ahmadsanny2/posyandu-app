<?php

namespace App\Http\Controllers;

use App\Models\Toddler;
use App\Models\PregnantWoman;
use App\Models\Elderly;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user->isParent()) {
            // Parent: family-scoped dashboard
            $toddlers = Toddler::where('user_id', $user->id)->get();
            $pregnantWomen = PregnantWoman::where('user_id', $user->id)->get();
            $elderlies = Elderly::where('user_id', $user->id)->get();

            // Fetch schedules relevant to their family profile types
            $targetTypes = [];
            if ($toddlers->isNotEmpty()) $targetTypes[] = 'toddler';
            if ($pregnantWomen->isNotEmpty()) $targetTypes[] = 'pregnant_woman';
            if ($elderlies->isNotEmpty()) $targetTypes[] = 'elderly';

            $schedulesQuery = Schedule::where('scheduled_at', '>=', now()->startOfDay());
            if (!empty($targetTypes)) {
                $schedulesQuery->whereIn('target_type', $targetTypes);
            }
            $schedules = $schedulesQuery->orderBy('scheduled_at', 'asc')->take(5)->get();

            return view('dashboard.parent', compact('toddlers', 'pregnantWomen', 'elderlies', 'schedules'));
        }

        // Admin or Kader: general analytics dashboard
        $stats = [
            'toddlers_count' => Toddler::count(),
            'pregnant_women_count' => PregnantWoman::count(),
            'elderlies_count' => Elderly::count(),
            'users_count' => User::count(),
        ];

        $schedules = Schedule::where('scheduled_at', '>=', now()->startOfDay())
            ->orderBy('scheduled_at', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.managerial', compact('stats', 'schedules'));
    }
}
