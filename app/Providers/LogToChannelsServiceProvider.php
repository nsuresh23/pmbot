<?php

/**
 * Logger service provider to be abled to log in different files
 *
 * @package    App\Providers
 * @author     Romain Laneuville <romain.laneuville@hotmail.fr>
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\LogToChannels;

/**
 * Class LogToChannelsServiceProvider
 *
 * @package App\Providers
 */
class LogToChannelsServiceProvider extends ServiceProvider
{
    /**
     * Initialize the logger
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Helpers\LogToChannels', function () {
            return new LogToChannels();
        });
    }
}
