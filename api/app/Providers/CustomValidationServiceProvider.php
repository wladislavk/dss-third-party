<?php
namespace DentalSleepSolutions\Providers;

use Illuminate\Support\ServiceProvider;
use DentalSleepSolutions\Validators\CustomValidator;

class CustomValidationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot () {
        \Validator::resolver(function($translator, $data, $rules, $messages) {
            return new CustomValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register () {
        //
    }
}
