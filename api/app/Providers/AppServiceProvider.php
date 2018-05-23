<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Services\ApiResponse\ApiResponseHelper;
use DentalSleepSolutions\Services\Misc\ClassRetriever;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
use Illuminate\Support\ServiceProvider;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \DB::listen(function ($query) {
            $dbLog = new Logger('Query');
            $dbLog->pushHandler(new RotatingFileHandler(storage_path('logs/query.log'), 5, Logger::DEBUG));
            $dbLog->info($query->sql, ['Bindings' => $query->bindings, 'Time' => $query->time]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ClassRetrieverInterface::class, ClassRetriever::class);
        $this->app->bind('apiresponse', ApiResponseHelper::class);
    }
}
