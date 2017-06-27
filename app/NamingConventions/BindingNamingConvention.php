<?php

namespace DentalSleepSolutions\NamingConventions;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Http\Requests\Request;

class BindingNamingConvention
{
    const BASE_NAMESPACE = 'DentalSleepSolutions';
    const HTTP_NAMESPACE = self::BASE_NAMESPACE . '\\Http';

    /** @var AbstractModel */
    private $model;

    /** @var BaseRestController */
    private $controller;

    /** @var Request */
    private $request;

    public function __construct($modelName = '')
    {
        if ($modelName) {
            $this->setModel($modelName);
        }
    }

    public function setModel($className)
    {
        $this->model = new $className();
        if (!$this->model instanceof AbstractModel) {
            throw new NamingConventionException("$className must extend " . AbstractModel::class);
        }
    }

    public function setController($className)
    {
        $this->controller = new $className();
        if (!$this->controller instanceof BaseRestController) {
            throw new NamingConventionException("$className must extend " . BaseRestController::class);
        }
    }

    public function setRequest($className)
    {
        $this->request = new $className();
        if (!$this->request instanceof Request) {
            throw new NamingConventionException("$className must extend " . Request::class);
        }
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getModel()
    {
        if (!$this->controller) {
            throw new NamingConventionException('setController() must be called before getModel()');
        }
        $name = $this->controller->getSingular();
        $namespace = $this->controller->getModelNamespace();
        $model = $namespace . '\\' . $name;
        if (!class_exists($model) || !is_subclass_of($model, AbstractModel::class)) {
            throw new NamingConventionException("$model must exist and extend " . AbstractModel::class);
        }
        return $model;
    }

    /**
     * @param string $namespace
     * @return string
     * @throws NamingConventionException
     */
    public function getController($namespace = self::HTTP_NAMESPACE)
    {
        $name = $this->model->getPlural();
        $namespace = $namespace . '\\Controllers';
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
        $name = $this->model->getSingular();
        $namespace = self::BASE_NAMESPACE . '\\Contracts\\Resources';
        $resource = $namespace . '\\' . $name;
        if (!interface_exists($resource) || !is_subclass_of($resource, Resource::class)) {
            throw new NamingConventionException("$resource must exist and extend " . Resource::class);
        }
        return $resource;
    }

    /**
     * @return string
     * @throws NamingConventionException
     */
    public function getRepository()
    {
        $name = $this->model->getPlural();
        $namespace = self::BASE_NAMESPACE . '\\Contracts\\Repositories';
        $repository = $namespace . '\\' . $name;
        if (!interface_exists($repository) || !is_subclass_of($repository, Repository::class)) {
            throw new NamingConventionException("$repository must exist and extend " . Repository::class);
        }
        return $repository;
    }

    /**
     * @param string $namespace
     * @return string
     * @throws NamingConventionException
     */
    public function getRequest($namespace = self::HTTP_NAMESPACE)
    {
        $name = '';
        if ($this->model) {
            $name = $this->model->getSingular();
        }
        if ($this->controller) {
            $name = $this->controller->getSingular();
        }
        $namespace = $namespace . '\\Requests';
        $request = $namespace . '\\' . $name;
        if (!class_exists($request) || !is_subclass_of($request, Request::class)) {
            throw new NamingConventionException("$request must exist and extend " . Request::class);
        }
        return $request;
    }
}
