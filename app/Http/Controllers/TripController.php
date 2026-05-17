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
            'tags'       => 'nullable|array|max:5',
            'tags.*'     => 'string|max:50',
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

    public function edit(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        return view('dashboard.create-trip', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'destination'=> 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'budget'     => 'nullable|numeric|min:0',
            'notes'      => 'nullable|string',
            'tags'       => 'nullable|array|max:5',
            'tags.*'     => 'string|max:50',
        ]);

        $trip->update($validated);

        return redirect()
            ->route('trips.show', $trip->id)
            ->with('success', 'Trip updated successfully.');
    }

    public function exportPdf(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        return view('trips.pdf', compact('trip'));
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

    public function toggleFavorite(Trip $trip)
    {
        if ($trip->user_id !== auth()->id()) {
            abort(403);
        }

        $trip->is_favorite = !$trip->is_favorite;
        $trip->save();

        return redirect()->back()->with('success', $trip->is_favorite ? 'Trip added to favorites.' : 'Trip removed from favorites.');
    }

    public function getWeather(Request $request, WeatherService $weatherService)
    {
        $city = $request->input('city');

        if (!$city) {
            return response()->json(['error' => 'City is required'], 400);
        }

        $weather = $weatherService->getWeatherForCity($city);

        if (!$weather) {
            return response()->json(['error' => 'Could not fetch weather data. Check your API key and connection.'], 500);
        }

        return response()->json($weather);
    }

    public function getForecast(Request $request, WeatherService $weatherService)
    {
        $city = $request->input('city');

        if (!$city) {
            return response()->json(['error' => 'City is required'], 400);
        }

        $forecast = $weatherService->getForecastForCity($city);

        if (!$forecast) {
            return response()->json(['error' => 'Could not fetch forecast data.'], 500);
        }

        return response()->json($forecast);
    }
}