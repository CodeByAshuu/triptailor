<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('landing');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('trips', TripController::class);
    Route::resource('activities', ActivityController::class);
});

Route::get('/dashboard', function(){
    return view('dashboard');
});