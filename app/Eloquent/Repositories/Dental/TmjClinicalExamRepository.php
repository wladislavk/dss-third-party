<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TmjClinicalExamRepository extends AbstractRepository
{
    public function model()
    {
        return TmjClinicalExam::class;
    }

    /**
     * @param  array  $data
     * @param  array  $where
     * @return boolean|int
     */
    public function updateWhere(array $data, array $where)
    {
        $query = $this->model;

        foreach ($where as $field => $value) {
            $query = $query->where($field, $value);
        }

        return $query->update($data);
    }
}
