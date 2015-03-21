<?php

namespace SQLgreyGUI\Providers;

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
        // Register Service Providers for local development
        if ($this->app->environment('local')) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }

}
