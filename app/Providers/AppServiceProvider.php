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
            \DentalSleepSolutions\Contracts\Repositories\Calendars::class,
            \DentalSleepSolutions\Eloquent\Dental\Calendar::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Calendar::class,
            \DentalSleepSolutions\Eloquent\Dental\Calendar::class
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
