<?php
namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class Ds3AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Ds3Auth\Ds3AuthInterface',
            'Ds3\Ds3Auth\Ds3Auth'
        );
    }
}
