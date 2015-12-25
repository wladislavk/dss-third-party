<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Admin;
use DentalSleepSolutions\Interfaces\Repositories\AdminInterface;

class AdminRepository extends BaseRepository implements AdminInterface
{
    /**
     * Main model name for the Admins Model
     *
     * @var string
     */
    protected $modelName = Admin::class;

    /**
     * Return all admins
     * 
     * @param string $orderBy 
     * @param array $relations 
     * @return mixed
     */
    public function all($orderBy = 'adminid', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        return $instance->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    /**
     * Find a single item.
     * 
     * @param integer $adminid 
     * @param array $relations 
     * @return mixed
     */
    public function find($adminId, array $relations = [])
    {
        $relations = null;
        $model = $this->getModelName();
        $this->instance = $model::find($adminId);
        return $this->instance;
    }

    /**
     * Create a new admin
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
     * Update a admin
     * 
     * @param integer $id 
     * @param array $data 
     * @return object
     */
    public function update($id, array $data = null)
    {
        $data = $data ?: \Input::all();
        $model = $this->getModelName();
        $this->instance = $model::find($id);

        foreach ($data as $field => $value) {
            $this->instance->$field = $value;
        }

        $this->instance->save();

        return $this->instance;
    }
}
