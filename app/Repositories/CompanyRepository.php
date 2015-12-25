<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Company;
use DentalSleepSolutions\Interfaces\Repositories\CompanyInterface;

class CompanyRepository extends BaseRepository implements CompanyInterface
{
    /**
     * Main model name for the Companies Model
     *
     * @var string
     */
    protected $modelName = Company::class;

    /**
     * Return all companies
     * 
     * @param string $orderBy 
     * @param array $relations 
     * @return mixed
     */
    public function all($orderBy = 'id', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        return $instance->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    /**
     * Find a single item.
     * 
     * @param integer $id 
     * @param array $relations 
     * @return mixed
     */
    public function find($id, array $relations = [])
    {
        $relations = null;
        $model = $this->getModelName();
        $this->instance = $model::find($id);
        return $this->instance;
    }

    /**
     * Create a new company
     * 
     * @param array $data 
     * @return object
     */
    public function store(array $data = null)
    {
        $data = $data ?: \Input::all();
        $model = $this->getModelName();
        $this->instance = new $model;

        foreach ($data as $field => $value) {
            $this->instance->$field = $value;
        }
        $this->instance->save();

        return $this->instance;
    }

    /**
     * Update a company
     * 
     * @param integer $id 
     * @param array $data 
     * @return object
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();
        $this->instance = parent::update($id, $data);
        return $this->instance;
    }
}
