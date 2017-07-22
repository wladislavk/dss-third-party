<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalCompanyRepository extends BaseRepository
{
    public function model()
    {
        return ExternalCompany::class;
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
     * @param string $apiKey
     * @return ExternalCompany|null
     */
    public function findByApiKey($apiKey)
    {
        return $this->model->where('api_key', $apiKey)->first();
    }
}
