<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Centaur\Middleware\SentinelAuthenticate', function ($app) {
            return new \App\Http\Middleware\TenantAuthenticate;
        });

        $this->app->bind('Centaur\Middleware\SentinelGuest', function ($app) {
            return new \App\Http\Middleware\TenantGuest;
        });

        $this->app->bind('Centaur\Middleware\SentinelUserHasAccess', function ($app) {
            return new \App\Http\Middleware\TenantUserHasAccess;
        });

        $this->app->bind('Centaur\Middleware\SentinelUserInRole', function ($app) {
            return new \App\Http\Middleware\TenantUserInRole;
        });
    }
}
