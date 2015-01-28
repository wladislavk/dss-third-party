<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\UserInterface',
            'Ds3\Admin\Repositories\UserRepository'
        );

        $this->app->bind(
        	'Ds3\Contracts\UserInterface',
        	'Ds3\Repositories\UserRepository'
        );

        $this->app->bind(
            'Ds3\Contracts\LoginInterface',
            'Ds3\Repositories\LoginRepository'
        );

        $this->app->bind(
        	'Ds3\Contracts\LoginDetailInterface',
        	'Ds3\Repositories\LoginDetailRepository'
        );
    }

}