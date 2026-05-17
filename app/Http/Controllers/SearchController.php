<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display the search dashboard page.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Fetch favorites and recent trips for initial empty state lists
        $favorites = $user->trips()->where('is_favorite', true)->latest()->take(3)->get();
        $recent = $user->trips()->latest()->take(3)->get();

        // Pluck unique labels used across user's trips for quick filters
        $tags = $user->trips()
            ->whereNotNull('tags')
            ->get()
            ->pluck('tags')
            ->flatten()
            ->unique()
            ->values()
            ->take(8);

        return view('dashboard.search', compact('favorites', 'recent', 'tags'));
    }

    /**
     * Perform live search queries and return JSON.
     */
    public function query(Request $request)
    {
        $query = trim($request->input('q'));
        $tagFilter = $request->input('tag');

        if (empty($query) && empty($tagFilter)) {
            return response()->json([]);
        }

        $user = auth()->user();
        $tripsQuery = $user->trips()->latest();

        if (!empty($query)) {
            $tripsQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('destination', 'like', "%{$query}%")
                  ->orWhere('notes', 'like', "%{$query}%")
                  ->orWhereJsonContains('tags', $query);
            });
        }

        if (!empty($tagFilter)) {
            $tripsQuery->whereJsonContains('tags', $tagFilter);
        }

        $results = $tripsQuery->get()->map(function ($trip) {
            return [
                'id' => $trip->id,
                'title' => $trip->title,
                'destination' => $trip->destination,
                'start_date' => $trip->start_date ? $trip->start_date->format('M d') : null,
                'end_date' => $trip->end_date ? $trip->end_date->format('M d, Y') : null,
                'notes_snippet' => $trip->notes ? (mb_strlen($trip->notes) > 85 ? mb_substr($trip->notes, 0, 85) . '...' : $trip->notes) : null,
                'tags' => $trip->tags ?? [],
                'is_favorite' => (bool)$trip->is_favorite,
                'url' => route('trips.show', $trip->id)
            ];
        });

        return response()->json($results);
    }
}
