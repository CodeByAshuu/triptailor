<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExploreController;

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

    Route::get('/dashboard', function () {
        return view('dashboard.home');
    })->name('dashboard');

    Route::get('/search', function () {
        return view('dashboard.search');
    })->name('search');

    Route::get('/filters', function () {
        return view('dashboard.filters');
    })->name('filters');

    Route::view('/trips', 'trips.trips')->name('trips.index');
    Route::get('/trips/create', function () {
        return view('dashboard.create-trip');
    })->name('trips.create');
    Route::view('/activities/create', 'activities.create')->name('activities.create');
});
