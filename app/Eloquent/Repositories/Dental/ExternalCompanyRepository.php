<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ExternalCompanyRepository extends AbstractRepository
{
    public function model()
    {
        return ExternalCompany::class;
    }

    /**
     * @param string $apiKey
     * @return ExternalCompany|null
     */
    public function findByApiKey($apiKey)
    {
        return $this->model->where('api_key', $apiKey)->first();
    }
}
