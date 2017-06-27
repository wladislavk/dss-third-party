<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Summary as Resource;
use DentalSleepSolutions\Contracts\Repositories\Summaries as Repository;

class Summary extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['summaryid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_summary';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'summaryid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * @param array $fields
     * @param array $where
     * @return Summary[]
     */
    public function getWithFilter($fields = [], $where = [])
    {
        $object = $this;

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

    public function updateForPatient($patientId = 0, $data = [])
    {
        $this->where('patientid', $patientId)
            ->update($data);
    }
}
