<?php

namespace DentalSleepSolutions\NamingConventions;

use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Http\Requests\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Tymon\JWTAuth\JWTAuth;

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

    /**
     * @param string $className
     * @throws NamingConventionException
     */
    public function setModel($className)
    {
        $this->model = new $className();
        if (!$this->model instanceof AbstractModel) {
            throw new NamingConventionException("$className must extend " . AbstractModel::class);
        }
    }

    /**
     * @todo: mocking classes indicates bad design, needs to be refactored
     *
     * @param string $className
     * @throws NamingConventionException
     */
    public function setController($className)
    {
        $jwtAuth = \Mockery::mock(JWTAuth::class);
        $jwtAuth->shouldReceive('toUser')->andReturnNull();
        $user = \Mockery::mock(User::class);
        $repository = \Mockery::mock(BaseRepository::class);
        $request = \Mockery::mock(Request::class);

        $this->controller = new $className($jwtAuth, $user, $repository, $request);
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
     * @param string $baseNamespace
     * @return string
     * @throws NamingConventionException
     */
    public function getResource($baseNamespace = self::BASE_NAMESPACE)
    {
//            throw new NamingConventionException("$resource must exist and extend " . Resource::class);
        return Resource::class;
    }

    /**
     * @param string $baseNamespace
     * @return string
     * @throws NamingConventionException
     */
    public function getRepository($baseNamespace = self::BASE_NAMESPACE)
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
