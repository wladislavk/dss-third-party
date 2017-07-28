<?php

namespace DentalSleepSolutions\NamingConventions;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Http\Controllers\BaseReferencedRestController;
use DentalSleepSolutions\Http\Controllers\BaseVersionedRestController;
use DentalSleepSolutions\Http\Requests\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Contracts\TransformerInterface;

class BindingNamingConvention
{
    const BASE_NAMESPACE = 'DentalSleepSolutions';
    const HTTP_NAMESPACE = self::BASE_NAMESPACE . '\\Http';
    const BASE_REST_CONTROLLERS = [
        BaseRestController::class,
        BaseReferencedRestController::class,
        BaseVersionedRestController::class,
    ];

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
        $userRepository = \Mockery::mock(UserRepository::class);
        $repository = \Mockery::mock(BaseRepository::class);
        $request = \Mockery::mock(Request::class);

        $this->controller = new $className($jwtAuth, $userRepository, $repository, $request);
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
        if (!class_exists($controller) || !$this->isRestfulController($controller)) {
            throw new NamingConventionException(
                "$controller must exist and extend a base REST controller like " . BaseRestController::class
            );
        }
        return $controller;
    }

    /**
     * @param string $baseNamespace
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

    /**
     * @param string $namespace
     * @return string
     * @throws NamingConventionException
     */
    public function getRequestTransformer($namespace = self::HTTP_NAMESPACE)
    {
        $name = $this->model->getSingular();
        $namespace = $namespace . '\\Transformers';
        $transformer = $namespace . '\\' . $name;

        if (!class_exists($transformer)) {
            return null;
        }

        if (!$this->implementsInterface($transformer, TransformerInterface::class)) {
            throw new NamingConventionException("$transformer must implement " . TransformerInterface::class);
        }

        return $transformer;
    }

    /**
     * @param string $controller
     * @return bool
     */
    private function isRestfulController($controller)
    {
        foreach (self::BASE_REST_CONTROLLERS as $baseClass) {
            if (is_subclass_of($controller, $baseClass)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $class
     * @param string $interface
     * @return bool
     */
    private function implementsInterface($class, $interface)
    {
        $interfaces = class_implements($class);
        return in_array($interface, $interfaces);
    }
}
