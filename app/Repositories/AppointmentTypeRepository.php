<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Dental\AppointmentType;
use DentalSleepSolutions\Interfaces\Repositories\AppointmentTypeInterface;

class AppointmentTypeRepository extends BaseRepository implements AppointmentTypeInterface
{
    /**
     * Main model name for the AppointmentType Model
     *
     * @var string
     */
    protected $modelName = AppointmentType::class;

    /**
     * Return all appointment types
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
     * Create a new appointment type
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
     * Update a appointment type
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
