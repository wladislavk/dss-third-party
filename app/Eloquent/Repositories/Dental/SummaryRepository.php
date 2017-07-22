<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use Prettus\Repository\Eloquent\BaseRepository;

class SummaryRepository extends BaseRepository
{
    public function model()
    {
        return Summary::class;
    }

    /**
     * @param int $patientId
     * @param array $data
     */
    public function updateForPatient($patientId, array $data)
    {
        $this->model->where('patientid', $patientId)->update($data);
    }

    /**
     * @param array $fields
     * @param array $where
     * @return Summary[]
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this->model;

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
}
