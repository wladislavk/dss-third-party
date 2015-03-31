<?php namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class AccessCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\AccessCodeInterface',
            'Ds3\Admin\Repositories\AccessCodeRepository'
        );
    }
}
