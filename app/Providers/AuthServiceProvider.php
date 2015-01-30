<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {


    public function register()
    {
        $this->app->bind(
            'Ds3\Auth\AuthenticateInterface',
            'Ds3\Auth\Authenticate'
        );
    }

}