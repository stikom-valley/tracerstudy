<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('isBPA', function ($user) {
            return $user->role->slug == 'bpa';
        });

        Gate::define('isWAREK', function ($user) {
            return $user->role->slug == 'warek-alumni';
        });
    }
}
