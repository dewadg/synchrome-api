<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register AuthService
        $this->app->singleton(\App\Services\AuthService::class, function () {
            return new \App\Services\AuthService;
        });

        // Register CalendarService
        $this->app->singleton(\App\Services\CalendarService::class, function () {
            return new \App\Services\CalendarService;
        });
    }
}
