<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Services\Auth\Guard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->app['auth']->extend('dental', function ($app, $name, array $config) {
            return new Guard($app->auth->createUserProvider($config['provider']));
        });
    }
}