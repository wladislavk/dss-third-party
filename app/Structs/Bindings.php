<?php

namespace DentalSleepSolutions\Structs;

class Bindings
{
    /** @var string */
    private $route;

    /** @var string */
    private $model;

    /** @var string */
    private $controller;

    /** @var string */
    private $resource;

    /** @var string */
    private $repository;

    /** @var string */
    private $storeRequest;

    /** @var string */
    private $updateRequest;

    /** @var string */
    private $destroyRequest;

    public function setRoute($route)
    {
        $this->route = strval($route);
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }

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

    public function setResource($resource)
    {
        $this->resource = strval($resource);
        return $this;
    }

    public function getResource()
    {
        return $this->resource;
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

    public function setStoreRequest($storeRequest)
    {
        $this->storeRequest = strval($storeRequest);
        return $this;
    }

    public function getStoreRequest()
    {
        return $this->storeRequest;
    }

    public function setUpdateRequest($updateRequest)
    {
        $this->updateRequest = strval($updateRequest);
        return $this;
    }

    public function getUpdateRequest()
    {
        return $this->updateRequest;
    }

    public function setDestroyRequest($destroyRequest)
    {
        $this->destroyRequest = strval($destroyRequest);
        return $this;
    }

    public function getDestroyRequest()
    {
        return $this->destroyRequest;
    }
}
