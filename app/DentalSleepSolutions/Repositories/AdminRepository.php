<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Interfaces\AdminInterface;

class AdminRepository extends BaseRepository implements AdminInterface
{
    /**
     * Main model name for the Admins Model
     *
     * @var string
     */
    protected $modelName = 'DentalSleepSolutions\Admin';

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
        return $this->instance();
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
        $this->instance = parent::store($data);
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
        $this->instance = parent::update($id, $data);
        return $this->instance;
    }
}
