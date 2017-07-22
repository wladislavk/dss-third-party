<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

abstract class AbstractRepository extends BaseRepository
{
    /**
     * @var Model|Builder
     */
    protected $model;

    /** @var string */
    private $orderBy = 'name';

    /** @var string */
    private $orderDirection = 'asc';

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this->model;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $orderBy
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function allWithOrder($orderBy = 'id', array $relations = [])
    {
        $this->parseOrder($orderBy);

        return $this->model
            ->with($relations)
            ->orderBy($this->getOrderBy(), $this->getOrderDirection())
            ->get();
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $orderBy
     * @return void
     */
    protected function parseOrder($orderBy)
    {
        if (substr($orderBy, -3) == 'Asc')
        {
            $this->setOrderDirection('asc');
            $orderBy = substr_replace($orderBy, '', -3);
        }

        if (substr($orderBy, -4) == 'Desc')
        {
            $this->setOrderDirection('desc');
            $orderBy = substr_replace($orderBy, '', -4);
        }

        $this->setOrderBy($orderBy);
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $orderBy
     * @return void
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $orderDirection
     * @return void
     */
    public function setOrderDirection($orderDirection)
    {
        $this->orderDirection = $orderDirection;
    }

    /**
     * @todo: check if this method is needed
     *
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @todo: check if this method is needed
     *
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $field
     * @param string $value
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function getBy($field, $value, array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where($field, $value)
            ->get();
    }

    /**
     * @todo: check if this method is needed
     *
     * @param string $field
     * @param string $value
     * @param array $relations
     * @return Model|null
     */
    public function getOneBy($field, $value, array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where($field, $value)
            ->first();
    }
}
