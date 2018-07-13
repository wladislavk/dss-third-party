<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Services\ApiResponse\ApiResponseHelper;
use DentalSleepSolutions\Temporary\ClassRetriever;
use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\GuzzleCaller;
use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\MockCaller;
use DentalSleepSolutions\Services\Misc\ThirdPartyCallers\ThirdPartyCallerInterface;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
use DentalSleepSolutions\Wrappers\PDF\DomPDFWrapper;
use DentalSleepSolutions\Wrappers\PDF\MockPDFWrapper;
use DentalSleepSolutions\Wrappers\PDF\PDFWrapperInterface;
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
        if ($this->app->environment() != 'production') {
            \DB::listen(function ($query) {
                $dbLog = new Logger('Query');
                $dbLog->pushHandler(new RotatingFileHandler(storage_path('logs/query.log'), 5, Logger::DEBUG));
                $dbLog->info($query->sql, ['Bindings' => $query->bindings, 'Time' => $query->time]);
            });
        }
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

        if ($this->app->environment() == 'testing') {
            $this->app->singleton(ThirdPartyCallerInterface::class, MockCaller::class);
            $this->app->bind(PDFWrapperInterface::class, MockPDFWrapper::class);
        } else {
            $this->app->bind(ThirdPartyCallerInterface::class, GuzzleCaller::class);
            $this->app->bind(PDFWrapperInterface::class, DomPDFWrapper::class);
        }
    }
}
