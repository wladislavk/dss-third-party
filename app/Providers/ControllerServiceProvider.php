<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Transformers\TransformerInterface;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use Illuminate\Support\ServiceProvider;

// this class binds common RESTful request and model interfaces to controllers
class ControllerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->app
                ->when($binding->getController())
                ->needs(Repository::class)
                ->give($binding->getModel())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(Request::class)
                ->give($binding->getRequest())
            ;

            if ($binding->getTransformer()) {
                $this->app
                    ->when($binding->getController())
                    ->needs(TransformerInterface::class)
                    ->give($binding->getTransformer())
                ;
            }
        }
    }
}
