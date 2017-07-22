<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalPatientRepository extends BaseRepository
{
    public function model()
    {
        return ExternalPatient::class;
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection
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

    /**
     * @param int $externalCompanyId
     * @param int $externalPatientId
     * @return ExternalPatient|null
     */
    public function findByExternalCompanyAndPatient($externalCompanyId, $externalPatientId)
    {
        return $this->model
            ->where('software', $externalCompanyId)
            ->where('external_id', $externalPatientId)
            ->first();
    }
}
