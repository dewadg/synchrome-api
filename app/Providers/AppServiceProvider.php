<?php

namespace App\Providers;

use App\Repositories\AccessRepo;
use App\Repositories\AttendanceTypeRepo;
use App\Repositories\CalendarRepo;
use App\Repositories\RankRepo;
use App\Repositories\RoleRepo;
use App\Services\AuthService;
use App\Services\CalendarService;
use App\Services\RankService;
use App\Services\RoleService;
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

        // Register RoleService
        $this->app->bind(RoleService::class, function () {
            return new RoleService(new RoleRepo, new AccessRepo);
        });

        // Register RankService
        $this->app->bind(RankService::class, function () {
            return new RankService(new RankRepo);
        });

        // Register CalendarService
        $this->app->bind(CalendarService::class, function () {
            return new CalendarService(new CalendarRepo, new AttendanceTypeRepo);
        });
    }
}
