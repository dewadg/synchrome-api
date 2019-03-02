<?php

namespace App\Providers;

use App\Repositories\RankRepo;
use App\Services\AuthService;
use App\Services\RankService;
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
        $this->app->singleton(AuthService::class, function () {
            return new AuthService;
        });

        // Register RankService
        $this->app->bind(RankService::class, function () {
            return new RankService(new RankRepo);
        });
    }
}
