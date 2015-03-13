<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\AdminInterface',
            'Ds3\Admin\Repositories\AdminRepository'
        );
    }
}
