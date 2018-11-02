<?php

namespace App\Providers;

use App\Exceptions\Auth\ExpiredAccessTokenException;
use App\Exceptions\Auth\InvalidAccessTokenException;
use App\Services\AuthService;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @param AuthService $service
     */
    public function boot(AuthService $service)
    {
        $this->app['auth']->viaRequest('api', function ($request) use ($service) {
            if ($request->header('Authorization')) {
                list($type, $token) = explode(' ', $request->header('Authorization'));

                if ($type !== 'Basic' || is_null($token)) {
                    return null;
                }

                list($username, $password) = explode(':', base64_decode($token));

                try {
                    return $service->authorize($username, $password);
                } catch (InvalidAccessTokenException $e) {
                    return null;
                } catch (ExpiredAccessTokenException $e) {
                    return null;
                }
            }
        });
    }
}
