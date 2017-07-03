<?php

namespace SQLgreyGUI\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use SQLgreyGUI\Repositories\UserProviderInterface;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::enableImplicitGrant();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        // Custom User Provider
        Auth::provider('sqlgreygui', function ($app, array $config) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...

            return $app->make(UserProviderInterface::class);
        });
    }
}
