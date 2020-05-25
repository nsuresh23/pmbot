<?php

namespace App\Providers;

use App\Models\User;
use App\Providers\CustomUserProvider;
use Illuminate\Support\ServiceProvider;

class CustomAuthProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->provider('custom', function () {
            return new CustomUserProvider(new User);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
