<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\BaseInterface;

class BaseRepository implements BaseInterface
{
    /**
     * Model name
     *
     * @var string
     */
    protected $modelName;

    /**
     * Current Object instance
     *
     * @var object
     */
    protected $instance;

    /**
     * Default order by
     *
     * @var string
     */
    private $orderBy = 'name';

    /**
     * Default order direction
     *
     * @var string
     */
    private $orderDirection = 'asc';

    /**
     * Return all records
     *
     * @param string $orderBy
     * @param array  $relations
     * @return mixed
     */
    public function all($orderBy = 'id', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        $this->parseOrder($orderBy);

        return $instance->with($relations)
            ->orderBy($this->getOrderBy(), $this->getOrderDirection())
            ->get();
    }

    /**
     * Return paginated items
     *
     * @param string  $orderBy
     * @param array   $relations
     * @param integer $paginate
     * @param array   $parameters
     * @return mixed
     */
    public function paginate($orderBy = 'name', array $relations = [], $paginate = 25, array $parameters = [])
    {
        $instance = $this->getQueryBuilder();
        $parameters = null;
        $this->parseOrder($orderBy);

        return $instance->with($relations)
            ->orderBy($this->getOrderBy(), $this->getOrderDirection())
            ->paginate($paginate);
    }

    /**
     * Get many records by a field and value
     *
     * @param string $field
     * @param string $value
     * @param array  $relations
     * @return mixed
     */
    public function getBy($field, $value, array $relations = [])
    {
        $instance = $this->getQueryBuilder();

        return $instance ->with($relations)->where($field, $value)->get();
    }

    /**
     * List all records
     *
     * @param string $fieldName
     * @param string $fieldId
     * @return mixed
     */
    public function lists($fieldName = 'name', $fieldId = 'id')
    {
        $instance = $this->getQueryBuilder();

        return $instance
            ->orderBy($fieldName)
            ->lists($fieldName, $fieldId);
    }

    /**
     * Find a single record
     *
     * @param integer $id
     * @param array   $relations
     * @return mixed
     */
    public function find($id, array $relations = [])
    {
        $model = $this->getModelName();
        $this->instance = $model::with($relations)->findOrFail($id);

        return $this->instance;
    }

    /**
     * Find a single record by a field and value
     * @param string $field
     * @param string $value
     * @param array  $relations
     * @return mixed
     */
    public function findBy($field, $value, array $relations = [])
    {
        $model = $this->getModelName();
        $this->instance = $model::with($relations)->where($field, $value)->first();

        return $this->instance;
    }

    /**
     * Find a single record by multiple fields
     *
     * @param array $data
     * @param array $relations
     * @return mixed
     */
    public function findByMany(array $data, array $relations = [])
    {
        $modelName = $this->getModelName();
        $model = $modelName::with($relations);

        foreach ($data as $key => $value)
        {
            $model->where($key, $value);
        }

        $this->instance = $model->first();

        return $this->instance;
    }

    /**
     * Create a new record
     *
     * @param array $data The input data
     * @return model instance
     */
    public function store(array $data = null)
    {
        $data = $data ?: \Input::all();

        return $this->executeStore($data);
    }

    /**
     * Execute the store method
     *
     * @param array $data The input data
     * @return model instance
     */
    protected function executeStore(array $data)
    {
        $this->instance = $this->getNewInstance();

        return $this->executeSave($data);
    }

    /**
     * Update the model instance
     *
     * @param integer $id
     * @param array   $data
     * @return model instance
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();

        return $this->executeUpdate($id, $data);
    }

    /**
     * Execute the update method
     *
     * @param integer $id
     * @param array   $data
     * @return model instance
     */
    protected function executeUpdate($id, array $data)
    {
        $this->instance = $this->find($id);

        return $this->executeSave($data);
    }

    /**
     * Save the model
     *
     * @param array $data
     * @return object
     */
    protected function executeSave(array $data)
    {
        $this->instance->fill($data);
        $this->instance->save();

        return $this->instance;
    }

    /**
     * Delete a record
     *
     * @param integer $id Model id
     * @return model instance
     */
    public function destroy($id)
    {
        $instance = $this->find($id);

        return $instance->delete();
    }

    /**
     * Checks whether the model has any errors
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return $this->instance->hasErrors();
    }

    /**
     * Returns model validation error messages
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->instance->getErrors();
    }

    /**
     * Return model name
     *
     * @return string
     * @throws \Exception If model has not been set.
     */
    public function getModelName()
    {
        if ( ! $this->modelName)
        {
            throw new \Exception('Model has not been set in ' . get_called_class());
        }

        return $this->modelName;
    }

    /**
     * Return a new query builder instance
     *
     * Implementation differs in BaseTenantRepo
     *
     * @return object
     */
    public function getQueryBuilder()
    {
        return $this->getNewInstance();
    }

    /**
     * Returns new model instance
     *
     * @return object
     */
    public function getNewInstance()
    {
        $model = $this->getModelName();

        return new $model;
    }

    /**
     * Parse the order by data
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
     * Set the order by field
     *
     * @param string $orderBy
     * @return void
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * Get the order by field
     *
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * Set the order direction
     *
     * @param string $orderDirection
     * @return void
     */
    public function setOrderDirection($orderDirection)
    {
        $this->orderDirection = $orderDirection;
    }

    /**
     * Get the order direction
     *
     * @return string
     */
    public function getOrderDirection()
    {
        return $this->orderDirection;
    }
}
