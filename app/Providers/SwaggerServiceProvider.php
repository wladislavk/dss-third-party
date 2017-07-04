<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Helpers\ClassRetriever;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
use Illuminate\Support\ServiceProvider;

class SwaggerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ClassRetrieverInterface::class, ClassRetriever::class);
    }
}
