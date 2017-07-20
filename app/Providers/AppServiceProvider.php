<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Eloquent;
use DentalSleepSolutions\Helpers\ClassRetriever;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->app->bind($binding->getResource(), $binding->getModel());
        }
        $externalBindings = BindingSetter::setExternalBindings();
        foreach ($externalBindings as $externalBinding) {
            $this->app->bind($externalBinding->getResource(), $externalBinding->getModel());
        }

        $this->app->bind(ClassRetrieverInterface::class, ClassRetriever::class);
    }
}
