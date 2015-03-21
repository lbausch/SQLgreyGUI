<?php

namespace SQLgreyGUI\Providers;

use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Load macros
        require app_path() . DIRECTORY_SEPARATOR . 'macros.php';
    }

}
