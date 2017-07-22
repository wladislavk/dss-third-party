<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Eloquent\BaseRepository;

// this class binds common RESTful request and model interfaces to controllers
class ControllerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->app
                ->when($binding->getController())
                ->needs(BaseRepository::class)
                ->give($binding->getRepository())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(Request::class)
                ->give($binding->getRequest())
            ;
        }
        $externalBindings = BindingSetter::setExternalBindings();
        foreach ($externalBindings as $externalBinding) {
            $this->app
                ->when($externalBinding->getController())
                ->needs(BaseRepository::class)
                ->give($externalBinding->getRepository())
            ;
        }
    }
}
