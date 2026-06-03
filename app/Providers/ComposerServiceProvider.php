<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View; // Import View
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Bagikan data ke view sidebar admin
        View::composer('layouts.partials.admin-sidebar', function ($view) {
            if (Auth::check()) { // Pastikan user sudah login
                $unreadNotificationsCount = Auth::user()->unreadNotifications()->count();
                $view->with('unreadNotificationsCount', $unreadNotificationsCount);
            } else {
                $view->with('unreadNotificationsCount', 0);
            }
        });
    }
}