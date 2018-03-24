<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Helpers\ApiResponseHelper;
use DentalSleepSolutions\Helpers\ClassRetriever;
use DentalSleepSolutions\StaticClasses\BindingSetter;
use DentalSleepSolutions\Swagger\ClassRetrieverInterface;
use Illuminate\Database\Eloquent\Model;
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
     * @throws \DentalSleepSolutions\Exceptions\NamingConventionException
     */
    public function register()
    {
        $bindings = BindingSetter::setBindings();
        foreach ($bindings as $binding) {
            $this->app->bind(Model::class, $binding->getModel());
        }
        $externalBindings = BindingSetter::setExternalBindings();
        foreach ($externalBindings as $externalBinding) {
            $this->app->bind(Model::class, $externalBinding->getModel());
        }

        $this->app->bind(ClassRetrieverInterface::class, ClassRetriever::class);

        $this->app->bind('apiresponse', ApiResponseHelper::class);
    }
}
