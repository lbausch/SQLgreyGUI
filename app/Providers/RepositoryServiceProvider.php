<?php

namespace SQLgreyGUI\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bindings for Repositories: Interface => Implementation.
     *
     * @var array
     */
    private static $bindings = [
        \SQLgreyGUI\Api\v1\Repositories\GreylistRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\GreylistRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\AwlEmailRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\AwlEmailRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\AwlDomainRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\AwlDomainRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\OptOutEmailRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\OptOutEmailRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\OptOutDomainRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\OptOutDomainRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\OptInEmailRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\OptInEmailRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\OptInDomainRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\OptInDomainRepositoryEloquent::class,
        \SQLgreyGUI\Api\v1\Repositories\UserRepositoryInterface::class => \SQLgreyGUI\Api\v1\Repositories\UserRepositoryEloquent::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
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
