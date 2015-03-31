<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\PlanInterface',
            'Ds3\Admin\Repositories\PlanRepository'
        );
    }
}
