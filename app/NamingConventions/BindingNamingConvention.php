<?php

namespace DentalSleepSolutions\NamingConventions;

use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Http\Requests\Request;
use Prettus\Repository\Eloquent\BaseRepository;

class BindingNamingConvention
{
    const BASE_NAMESPACE = 'DentalSleepSolutions';

    /** @var AbstractModel */
    private $model;

    public function __construct($modelName)
    {
        $this->model = new $modelName();
        if (!$this->model instanceof AbstractModel) {
            throw new NamingConventionException("$modelName must extend " . AbstractModel::class);
        }
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getController()
    {
        $name = $this->model->getPlural();
        $namespace = self::BASE_NAMESPACE . '\\Http\\Controllers';
        $suffix = 'Controller';
        $controller = $namespace . '\\' . $name . $suffix;
        if (!class_exists($controller) || !is_subclass_of($controller, BaseRestController::class)) {
            throw new NamingConventionException("$controller must exist and extend " . BaseRestController::class);
        }
        return $controller;
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getResource()
    {
//            throw new NamingConventionException("$resource must exist and extend " . Resource::class);
        return Resource::class;
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getRepository()
    {
        $modelClassName = get_class($this->model);
        $repoClassName = $modelClassName . 'Repository';
        $repoClassName = str_replace('Models', 'Repositories', $repoClassName);
        if (!class_exists($repoClassName) || !is_subclass_of($repoClassName, BaseRepository::class)) {
            throw new NamingConventionException("$repoClassName must exist and extend " . BaseRepository::class);
        }
        return $repoClassName;
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getRequest()
    {
        $name = $this->model->getSingular();
        $namespace = self::BASE_NAMESPACE . '\\Http\\Requests';
        $request = $namespace . '\\' . $name;
        if (!class_exists($request) || !is_subclass_of($request, Request::class)) {
            throw new NamingConventionException("$request must exist and extend " . Request::class);
        }
        return $request;
    }
}
