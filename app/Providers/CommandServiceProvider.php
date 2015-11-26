<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Support\ServiceProvider;
use DentalSleepSolutions\Console\Commands\Api\Model;
use DentalSleepSolutions\Console\Commands\Api\Route;
use DentalSleepSolutions\Console\Commands\Api\Requests;
use DentalSleepSolutions\Console\Commands\Api\Resource;
use DentalSleepSolutions\Console\Commands\Api\Controller;
use DentalSleepSolutions\Console\Commands\Api\Transformer;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModelGenerator();
        $this->registerRouteGenerator();
        $this->registerRequestsGenerator();
        $this->registerResourceGenerator();
        $this->registerControllerGenerator();
        $this->registerTransformerGenerator();

        $this->commands(
            'command.api.model',
            'command.api.route',
            'command.api.requests',
            'command.api.resource',
            'command.api.controller',
            'command.api.transformer'
        );
    }

    /**
     * Register the model generator command.
     *
     * @return void
     */
    protected function registerModelGenerator()
    {
        $this->app->singleton('command.api.model', function ($app) {
            return new Model($app['files']);
        });
    }

    /**
     * Register the route generator command.
     *
     * @return void
     */
    protected function registerRouteGenerator()
    {
        $this->app->singleton('command.api.route', function ($app) {
            return new Route($app['files']);
        });
    }

    /**
     * Register the requests generator command.
     *
     * @return void
     */
    protected function registerRequestsGenerator()
    {
        $this->app->singleton('command.api.requests', function ($app) {
            return new Requests($app['files']);
        });
    }

    /**
     * Register the complete REST resource generator command.
     *
     * @return void
     */
    protected function registerResourceGenerator()
    {
        $this->app->singleton('command.api.resource', function ($app) {
            return new Resource;
        });
    }

    /**
     * Register the controller generator command.
     *
     * @return void
     */
    protected function registerControllerGenerator()
    {
        $this->app->singleton('command.api.controller', function ($app) {
            return new Controller($app['files']);
        });
    }


    /**
     * Register the transformer generator command.
     *
     * @return void
     */
    protected function registerTransformerGenerator()
    {
        $this->app->singleton('command.api.transformer', function ($app) {
            return new Transformer($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.api.model',
            'command.api.route',
            'command.api.requests',
            'command.api.resource',
            'command.api.controller',
            'command.api.transformer'
        ];
    }
}
