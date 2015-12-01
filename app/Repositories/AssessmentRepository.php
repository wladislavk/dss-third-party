<?php
namespace DentalSleepSolutions\Repositories;

use DentalSleepSolutions\Models\Assessment;
use DentalSleepSolutions\Interfaces\Repositories\AssessmentInterface;

class AssessmentRepository extends BaseRepository implements AssessmentInterface
{
    /**
     * Main model name for the Assessment Model
     *
     * @var string
     */
    protected $modelName = Assessment::class;

    /**
     * Return all assessments
     * 
     * @param string $orderBy 
     * @param array $relations 
     * @return mixed
     */
    public function all($orderBy = 'assessmentid', array $relations = [])
    {
        $instance = $this->getQueryBuilder();
        return $instance->with($relations)
            ->orderBy($orderBy)
            ->get();
    }

    /**
     * Find a single item.
     * 
     * @param integer $assessmentId 
     * @param array $relations 
     * @return mixed
     */
    public function find($assessmentId, array $relations = [])
    {
        $relations = null;
        $model = $this->getModelName();
        $this->instance = $model::find($assessmentId);
        return $this->instance;
    }

    /**
     * Create a new assessment
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
     * Update an assessment
     * 
     * @param integer $assessmentId 
     * @param array $data 
     * @return object
     */
    public function update($assessmentId, array $data = null)
    {
        $data = $data ?: \Input::all();
        $this->instance = parent::update($assessmentId, $data);
        return $this->instance;
    }
}
