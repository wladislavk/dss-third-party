<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\UserInterface',
            'Ds3\Admin\Repositories\UserRepository'
        );
    }

}