<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Support\ServiceProvider;
use DentalSleepSolutions\Console\Commands\Api\Controller;

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
        $this->registerControllerGenerator();

        $this->commands('command.api:controller');
    }

    /**
     * Register the controller generator command.
     *
     * @return void
     */
    protected function registerControllerGenerator()
    {
        $this->app->singleton('command.api:controller', function ($app) {
            return new Controller($app['files']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array(
            'command.api:controller',
        );
    }
}
