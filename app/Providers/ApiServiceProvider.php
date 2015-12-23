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
        $this->app->bind('DentalSleepSolutions\\Interfaces\\MemoAdminInterface',
                        'DentalSleepSolutions\\Repositories\\MemoAdminRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\EnrollmentPayersInterface',
                        'DentalSleepSolutions\\Repositories\\EnrollmentPayersApiRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\EnrollmentInterface',
                        'DentalSleepSolutions\\Repositories\\EnrollmentRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\UserSignaturesInterface',
                        'DentalSleepSolutions\\Repositories\\UserSignaturesRepository');

        $this->app->bind('DentalSleepSolutions\\Interfaces\\Repositories\\ContactTypeInterface',
                        'DentalSleepSolutions\\Repositories\\ContactTypeRepository');
    }
}
