<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [TripController::class, 'index']);
    Route::resource('trips', TripController::class);
    Route::resource('activities', ActivityController::class);
});
