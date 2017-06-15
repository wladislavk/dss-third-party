<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Contracts\Repositories\ChangeLists;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Eloquent\Dental\ChangeList;
use DentalSleepSolutions\Http\Controllers\ChangeListsController;
use DentalSleepSolutions\Http\Requests\AbstractDestroyRequest;
use DentalSleepSolutions\Http\Requests\AbstractStoreRequest;
use DentalSleepSolutions\Http\Requests\AbstractUpdateRequest;
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
                ->needs(Resource::class)
                ->give($binding->getModel())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(Repository::class)
                ->give($binding->getModel())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(AbstractStoreRequest::class)
                ->give($binding->getStoreRequest())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(AbstractUpdateRequest::class)
                ->give($binding->getUpdateRequest())
            ;
            $this->app
                ->when($binding->getController())
                ->needs(AbstractDestroyRequest::class)
                ->give($binding->getDestroyRequest())
            ;
        }
    }
}
