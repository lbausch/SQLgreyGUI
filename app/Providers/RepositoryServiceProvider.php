<?php

namespace SQLgreyGUI\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bindings for Repositories
     * Interface => Implementation.
     * 
     * @var array
     */
    private static $bindings = [
        'SQLgreyGUI\Repositories\GreylistRepositoryInterface' => 'SQLgreyGUI\Repositories\GreylistRepositoryEloquent',
        'SQLgreyGUI\Repositories\AwlEmailRepositoryInterface' => 'SQLgreyGUI\Repositories\AwlEmailRepositoryEloquent',
        'SQLgreyGUI\Repositories\AwlDomainRepositoryInterface' => 'SQLgreyGUI\Repositories\AwlDomainRepositoryEloquent',
        'SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface' => 'SQLgreyGUI\Repositories\OptOutEmailRepositoryEloquent',
        'SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface' => 'SQLgreyGUI\Repositories\OptOutDomainRepositoryEloquent',
        'SQLgreyGUI\Repositories\OptInEmailRepositoryInterface' => 'SQLgreyGUI\Repositories\OptInEmailRepositoryEloquent',
        'SQLgreyGUI\Repositories\OptInDomainRepositoryInterface' => 'SQLgreyGUI\Repositories\OptInDomainRepositoryEloquent',
        'SQLgreyGUI\Repositories\UserRepositoryInterface' => 'SQLgreyGUI\Repositories\UserRepositoryEloquent',
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        foreach (self::$bindings as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }
}
