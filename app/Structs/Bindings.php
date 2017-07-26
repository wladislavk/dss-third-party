<?php

namespace DentalSleepSolutions\Structs;

class Bindings
{
    /** @var string */
    private $model;

    /** @var string */
    private $controller;

    /** @var string */
    private $repository;

    /** @var string */
    private $request;

    public function setModel($model)
    {
        $this->model = strval($model);
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setController($controller)
    {
        $this->controller = strval($controller);
        return $this;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setRepository($repository)
    {
        $this->repository = strval($repository);
        return $this;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRequest($request)
    {
        $this->request = strval($request);
        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
