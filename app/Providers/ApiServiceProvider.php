<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
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
        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\MemoAdminInterface',
                        'DentalSleepSolutions\\Repositories\\MemoAdminRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\EnrollmentPayersInterface',
                        'DentalSleepSolutions\\Repositories\\EnrollmentPayersApiRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\EnrollmentInterface',
                        'DentalSleepSolutions\\Repositories\\EnrollmentRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\UserSignaturesInterface',
                        'DentalSleepSolutions\\Repositories\\UserSignaturesRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\AllergenInterface',
                        'DentalSleepSolutions\\Repositories\\AllergenRepository');
    }
}
