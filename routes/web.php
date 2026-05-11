<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('landing');
});
Route::get('/explore',function (){
    return view('explore');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [TripController::class, 'index'])->name('dashboard');
    Route::resource('trips', TripController::class);
    Route::resource('activities', ActivityController::class);
});

Route::get('/dashboard', function(){
    return view('dashboard');
});
Route::middleware('guest')->group(function () {
    Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
    Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
    Route::get('/register', [AuthController::class, 'showAuthForm'])->name('register');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationNotification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});