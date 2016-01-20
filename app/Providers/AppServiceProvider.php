<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Eloquent;
use Illuminate\Support\ServiceProvider;
use DentalSleepSolutions\Contracts\Resources;
use DentalSleepSolutions\Contracts\Repositories;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $bindings = [
            Eloquent\Device::class => [Repositories\Devices::class, Resources\Device::class],
            Eloquent\Payer::class => [Repositories\Payers::class, Resources\Device::class],
        ];

        foreach ($bindings as $concrete => $contracts) {
            foreach ((array)$contracts as $contract) {
                $this->app->bind($contract, $concrete);
            }
        }
    }
}
