<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bind authenticated user's trips to the dashboard layout and sidebar component
        View::composer(['layouts.dashboard', 'components.dashboard.sidebar'], function ($view) {
            if (Auth::check()) {
                $view->with('trips', Auth::user()->trips()->latest()->get());
            } else {
                $view->with('trips', collect());
            }
        });
    }
}
