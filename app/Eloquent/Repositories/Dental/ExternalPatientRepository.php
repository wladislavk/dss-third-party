<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalPatient;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ExternalPatientRepository extends AbstractRepository
{
    public function model()
    {
        return ExternalPatient::class;
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
