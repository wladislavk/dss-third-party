<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ExternalUserRepository extends AbstractRepository
{
    public function model()
    {
        return ExternalUser::class;
    }

    /**
     * @param string $apiKey
     * @return ExternalUser|null
     */
    public function findByApiKey($apiKey)
    {
        return $this->model->where('api_key', $apiKey)->first();
    }

    /**
     * @param int $id
     * @return ExternalUser
     */
    public function findFirstById($id)
    {
        return $this->model->where('user_id', $id)->firstOrFail();
    }
}
