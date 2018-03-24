<?php

namespace DentalSleepSolutions\Providers;

use DentalSleepSolutions\Eloquent\Repositories\PayerRepository;
use Illuminate\Routing\Router;
use DentalSleepSolutions\Exceptions\ResourceNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'DentalSleepSolutions\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('payer_id', function ($uid) {
            try {
                /** @var PayerRepository $payerRepository */
                $payerRepository = $this->app[PayerRepository::class];
                return $payerRepository->findByUid($uid);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFoundException('Requested resource does not exist.');
            }
        });

        parent::boot();
    }

    /**
     * Bind resource to a route and let controllers use its instance rather than id.
     *
     * @param  string $routeName   Url parameter name.
     * @param  string $modelClass Resource class name.
     * @return void
     */
    protected function bindResource($routeName, $modelClass)
    {
        $this->app['router']->bind($routeName, function ($id) use ($modelClass) {
            try {
                return $modelClass::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFoundException('Requested resource does not exist.');
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });

        // these routes are needed for GenerateSwaggerCommandTest
        if (env('APP_ENV') == 'testing') {
            $namespace = 'Tests\Dummies\Http\Controllers';
            $router->group(['namespace' => $namespace], function ($router) {
                require __DIR__ . '/../../tests/Dummies/routes.php';
            });
        }
    }
}
