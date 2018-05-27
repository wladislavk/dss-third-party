<?php

namespace DentalSleepSolutions\NamingConventions;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Exceptions\NamingConventionException;
use DentalSleepSolutions\Http\Controllers\BaseRestController;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use DentalSleepSolutions\Contracts\TransformerInterface;
use Illuminate\Contracts\Auth\Factory as Auth;

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

    /**
     * BindingNamingConvention constructor.
     * @param string $modelName
     * @throws NamingConventionException
     */
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
        $auth = \Mockery::mock(Auth::class);
        $config = \Mockery::mock(Config::class);
        $repository = \Mockery::mock(AbstractRepository::class);
        $request = \Mockery::mock(Request::class);

        $auth->shouldReceive('guard')
            ->andReturnNull()
        ;
        $request->shouldReceive('user')->once();
        $request->shouldReceive('patient')
            ->once()
        ;
        $request->shouldReceive('admin')->once()->andReturnNull();
        $config->shouldReceive('get')->andReturnNull();

        $this->controller = new $className($auth, $config, $repository, $request);
        if (!$this->controller instanceof BaseRestController) {
            throw new NamingConventionException("$className must extend " . BaseRestController::class);
        }
    }

    /**
     * @param string $className
     * @throws NamingConventionException
     */
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
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
    public function getRepository()
    {
        $modelClassName = get_class($this->model);
        $repoClassName = $modelClassName . 'Repository';
        $repoClassName = str_replace('Models', 'Repositories', $repoClassName);
        if (!class_exists($repoClassName) || !is_subclass_of($repoClassName, AbstractRepository::class)) {
            throw new NamingConventionException("$repoClassName must exist and extend " . AbstractRepository::class);
        }
        return $repoClassName;
    }

    /**
     * @param string $namespace
     * @return string
     * @throws NamingConventionException
     * @throws \ReflectionException
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
     * @throws \ReflectionException
     */
    public function getRequestTransformer($namespace = self::HTTP_NAMESPACE)
    {
        $name = $this->model->getSingular();
        $namespace = $namespace . '\\Transformers';
        $transformer = $namespace . '\\' . $name;

        if (!class_exists($transformer)) {
            return null;
        }

        if (!is_subclass_of($transformer, TransformerInterface::class)) {
            throw new NamingConventionException("$transformer must implement " . TransformerInterface::class);
        }

        return $transformer;
    }
}
