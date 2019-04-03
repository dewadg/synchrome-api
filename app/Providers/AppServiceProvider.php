<?php

namespace App\Providers;

use App\Repositories\AccessRepo;
use App\Repositories\AgencyRepo;
use App\Repositories\AttendanceTypeRepo;
use App\Repositories\CalendarRepo;
use App\Repositories\EchelonRepo;
use App\Repositories\EchelonTypeRepo;
use App\Repositories\RankRepo;
use App\Repositories\RoleRepo;
use App\Repositories\TppRepo;
use App\Repositories\WorkshiftRepo;
use App\Services\AuthService;
use App\Services\AgencyService;
use App\Services\CalendarService;
use App\Services\EchelonService;
use App\Services\RankService;
use App\Services\RoleService;
use App\Services\TppService;
use App\Services\WorkshiftService;
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

        // Register WorkshiftService
        $this->app->bind(WorkshiftService::class, function () {
            return new WorkshiftService(new WorkshiftRepo);
        });

        // Register AgencyService
        $this->app->bind(AgencyService::class, function () {
            return new AgencyService(new AgencyRepo, new EchelonRepo);
        });

        // Register EchelonService
        $this->app->bind(EchelonService::class, function () {
            return new EchelonService(new EchelonRepo, new EchelonTypeRepo);
        });

        // Register TppService
        $this->app->bind(TppService::class, function () {
            return new TppService(new TppRepo);
        });
    }
}
