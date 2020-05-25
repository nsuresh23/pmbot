<?php

namespace App\Providers;

use App\Models\Job\Task;
use App\Models\Observer\Job\TaskObserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
         Schema::defaultStringLength(191);

        Task::observe(TaskObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
