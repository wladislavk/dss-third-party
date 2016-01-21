<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Routing\Router;
use DentalSleepSolutions\Exceptions\ResourceNotFound;
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
     * Route model bindings for the resources.
     *
     * @var array
     */
    protected $resourceBindings = [
        'contact-types' => \DentalSleepSolutions\Eloquent\Dental\ContactType::class,
        'contacts' => \DentalSleepSolutions\Eloquent\Dental\Contact::class,
        'devices' => \DentalSleepSolutions\Eloquent\Dental\Device::class,
        'payers' => \DentalSleepSolutions\Eloquent\Payer::class,
        'companies' => \DentalSleepSolutions\Eloquent\Company::class,
    ];

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        foreach ($this->resourceBindings as $key => $resource) {
            $this->bindResource($key, $resource);
        }

        $router->bind('payer_id', function ($uid) {
            try {
                return $this->app[\DentalSleepSolutions\Contracts\Repositories\Payers::class]->findByUid($uid);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFound('Requested resource does not exist.');
            }
        });

        parent::boot($router);
    }

    /**
     * Bind resource to a route and let controllers use its instance rather than id.
     *
     * @param  string $key   Url parameter name.
     * @param  string $class Resource class name.
     * @return void
     */
    protected function bindResource($key, $class)
    {
        $this->app['router']->bind($key, function ($id) use ($class) {
            try {
                return $class::findOrFail($id);
            } catch (ModelNotFoundException $e) {
                throw new ResourceNotFound('Requested resource does not exist.');
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
    }
}
