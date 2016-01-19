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
            \DentalSleepSolutions\Contracts\Repositories\Assessments::class,
            \DentalSleepSolutions\Eloquent\Dental\Assessment::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Assessment::class,
            \DentalSleepSolutions\Eloquent\Dental\Assessment::class
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
