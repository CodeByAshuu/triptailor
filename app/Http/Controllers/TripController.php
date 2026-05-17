<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function create()
    {
        return view('dashboard.create-trip');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'destination'=> 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'budget'     => 'nullable|numeric|min:0',
            'notes'      => 'nullable|string',
        ]);

        $trip = Trip::create([
            ...$validated,
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('trips.show', $trip->id)
            ->with('success', 'Trip created successfully.');
    }

    public function show(Trip $trip)
    {
        // Optional: authorize so users can't view each other's trips
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        return view('trips.show', compact('trip'));
    }

    public function destroy(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $trip->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Trip deleted successfully.');
    }

    public function getWeather(Request $request, WeatherService $weatherService)
    {
        $city = $request->input('city');

        if (!$city) {
            return response()->json(['error' => 'City is required'], 400);
        }

        $weather = $weatherService->getWeatherForCity($city);

        if (!$weather) {
            return response()->json(['error' => 'Could not fetch weather for this location.'], 404);
        }

        return response()->json($weather);
    }
}