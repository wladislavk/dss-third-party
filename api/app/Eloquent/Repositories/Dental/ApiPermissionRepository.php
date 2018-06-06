<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ApiPermission;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Closure;

class ApiPermissionRepository extends AbstractRepository
{
    public function model()
    {
        return ApiPermission::class;
    }

    /**
     * @param Closure $filter
     */
    public function deleteWithFilter(Closure $filter)
    {
        $this->model->where($filter)->delete();
    }

    /**
     * @param array $values
     */
    public function bulkInsert(array $values)
    {
        foreach ($values as $value) {
            $this->model->updateOrCreate($value, $value);
        }
    }
}
