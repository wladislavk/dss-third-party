<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class BackOfficeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\BackOfficeUserInterface',
            'Ds3\Admin\Repositories\BackOfficeUserRepository'
        );
    }
}
