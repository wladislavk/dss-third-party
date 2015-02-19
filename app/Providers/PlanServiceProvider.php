<?php
/**
 * Created by PhpStorm.
 * User: saqib
 * Date: 2/13/15
 * Time: 10:40 AM
 */

namespace Ds3\Providers;


use Illuminate\Support\ServiceProvider;

class PlanServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\PlanInterface',
            'Ds3\Admin\Repositories\PlanRepository'
        );
    }

}