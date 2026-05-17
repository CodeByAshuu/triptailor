<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Render the main dashboard landing view with dynamic travel analytics.
     */
    public function index()
    {
        $user = auth()->user();
        $today = Carbon::today();

        // 1. Find if there is any currently active trip (today is between start_date and end_date)
        $upcomingTrip = $user->trips()
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();

        // 2. If no active trip, find the nearest upcoming trip starting after today
        if (!$upcomingTrip) {
            $upcomingTrip = $user->trips()
                ->where('start_date', '>', $today)
                ->orderBy('start_date', 'asc')
                ->first();
        }

        // 3. Fallback: If no active or future trips, get the most recently ended/created trip
        if (!$upcomingTrip) {
            $upcomingTrip = $user->trips()
                ->orderBy('end_date', 'desc')
                ->first();
        }

        $daysRemaining = null;
        if ($upcomingTrip) {
            $daysRemaining = (int) $today->diffInDays($upcomingTrip->start_date, false);
        }

        // 2. Fetch other trips for the planning list (exclude the upcoming highlighted one)
        $excludeId = $upcomingTrip ? $upcomingTrip->id : null;
        $planningTrips = $user->trips()
            ->when($excludeId, function ($query, $excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->latest()
            ->get();

        // 3. Count metrics
        $totalTrips = $user->trips()->count();
        $favoritesCount = $user->trips()->where('is_favorite', true)->count();

        return view('dashboard.home', compact(
            'upcomingTrip', 
            'daysRemaining', 
            'planningTrips', 
            'totalTrips',
            'favoritesCount'
        ));
    }
}
