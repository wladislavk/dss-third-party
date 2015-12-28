<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Dental\Calendar;
use DentalSleepSolutions\Interfaces\Repositories\CalendarInterface;

class CalendarRepository extends BaseRepository implements CalendarInterface
{
    /**
     * Main model name for the Calendar Model
     *
     * @var string
     */
    protected $modelName = Calendar::class;

    /**
     * Return all calendars
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
     * Create a new calendar
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
     * Update a calendar
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
