<?php
namespace Ds3\Providers;

use Illuminate\Support\ServiceProvider;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Ds3\Admin\Contracts\CompanyInterface',
            'Ds3\Admin\Repositories\CompanyRepository'
        );
    }
}
