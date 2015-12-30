<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Dental\Custom;
use DentalSleepSolutions\Interfaces\Repositories\CustomInterface;

class CustomRepository extends BaseRepository implements CustomInterface
{
    /**
     * Main model name for the Custom Model
     *
     * @var string
     */
    protected $modelName = Custom::class;

    /**
     * Return all Customs
     * 
     * @param string $orderBy 
     * @param array $relations 
     * @return mixed
     */
    public function all($orderBy = 'customid', array $relations = [])
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
     * Create a new Custom
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
     * Update a Custom
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
