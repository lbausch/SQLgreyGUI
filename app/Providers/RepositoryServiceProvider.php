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
        \SQLgreyGUI\Repositories\GreylistRepositoryInterface::class => \SQLgreyGUI\Repositories\GreylistRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\AwlEmailRepositoryInterface::class => \SQLgreyGUI\Repositories\AwlEmailRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\AwlDomainRepositoryInterface::class => \SQLgreyGUI\Repositories\AwlDomainRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\OptOutEmailRepositoryInterface::class => \SQLgreyGUI\Repositories\OptOutEmailRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\OptOutDomainRepositoryInterface::class => \SQLgreyGUI\Repositories\OptOutDomainRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\OptInEmailRepositoryInterface::class => \SQLgreyGUI\Repositories\OptInEmailRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\OptInDomainRepositoryInterface::class => \SQLgreyGUI\Repositories\OptInDomainRepositoryEloquent::class,
        \SQLgreyGUI\Repositories\UserRepositoryInterface::class => \SQLgreyGUI\Repositories\UserRepositoryEloquent::class,
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
