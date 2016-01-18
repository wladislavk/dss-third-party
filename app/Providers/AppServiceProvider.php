<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\Payers::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Payer::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );

        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\Charges::class,
            \DentalSleepSolutions\Eloquent\Charge::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Charge::class,
            \DentalSleepSolutions\Eloquent\Charge::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
