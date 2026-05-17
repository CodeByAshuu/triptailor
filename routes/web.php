<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/explore', [ExploreController::class, 'index'])->name('explore');

Route::middleware('guest')->group(function () {
    Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
    Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showAuthForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/get-started', function () {
        return view('dashboard.get-started');
    })->name('get-started');

    Route::get('/search', [SearchController::class, 'index'])->name('search');
    Route::get('/search/query', [SearchController::class, 'query'])->name('search.query');

    Route::get('/filters', function () {
        $user = auth()->user();
        
        // Get all user trips
        $allTrips = $user->trips()->latest()->get();
        
        // Extract all unique tags used in their trips
        $uniqueTags = $allTrips->pluck('tags')
            ->filter()
            ->flatten()
            ->unique()
            ->values();
            
        $selectedTag = request('tag');
        
        // Filter trips by tag if requested
        $filteredTrips = $selectedTag
            ? $allTrips->filter(fn($trip) => is_array($trip->tags) && in_array($selectedTag, $trip->tags))
            : $allTrips;

        return view('dashboard.filters', [
            'tags' => $uniqueTags,
            'selectedTag' => $selectedTag,
            'trips' => $filteredTrips,
            'allTripsCount' => $allTrips->count()
        ]);
    })->name('filters');

    Route::view('/trips', 'trips.trips')->name('trips.index');
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');
    Route::get('/trips/weather-preview', [TripController::class, 'getWeather'])->name('trips.weather');
    Route::view('/activities/create', 'activities.create')->name('activities.create');
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
    Route::post('/trips/{trip}/toggle-favorite', [TripController::class, 'toggleFavorite'])->name('trips.toggle-favorite');
});
