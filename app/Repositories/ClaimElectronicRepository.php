<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Eloquent\Dental\ClaimElectronic;
use DentalSleepSolutions\Interfaces\Repositories\ClaimElectronicInterface;

class ClaimElectronicRepository extends BaseRepository implements ClaimElectronicInterface
{
    /**
     * Main model name for the ClaimsElectronic Model
     *
     * @var string
     */
    protected $modelName = ClaimElectronic::class;

    /**
     * Return all claim electronic
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
     * Create a new claim electronic
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
     * Update a claim electronic
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
