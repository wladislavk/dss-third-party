<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Eloquent;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use Illuminate\Support\ServiceProvider;
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
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\Payers::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\Payer::class,
            \DentalSleepSolutions\Eloquent\Payer::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\AppointmentTypes::class,
            \DentalSleepSolutions\Eloquent\Dental\AppointmentType::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\AppointmentType::class,
            \DentalSleepSolutions\Eloquent\Dental\AppointmentType::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Repositories\AccessCodes::class,
            \DentalSleepSolutions\Eloquent\Dental\AccessCode::class
        );
        $this->app->bind(
            \DentalSleepSolutions\Contracts\Resources\AccessCode::class,
            \DentalSleepSolutions\Eloquent\Dental\AccessCode::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            Repositories\Complaints::class,
            Eloquent\Dental\Complaint::class
        );

        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->app->bind($binding->getResource(), $binding->getModel());
            $this->app->bind($binding->getRepository(), $binding->getModel());
        }

        $this->app->bind(
            Repositories\ClaimNoteAttachments::class,
            Eloquent\Dental\ClaimNoteAttachment::class
        );
    }
}
