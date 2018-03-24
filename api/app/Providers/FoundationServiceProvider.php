<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Foundation\Providers\FoundationServiceProvider as BaseServiceProvider;

class FoundationServiceProvider extends BaseServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        FormRequestServiceProvider::class,
    ];
}
