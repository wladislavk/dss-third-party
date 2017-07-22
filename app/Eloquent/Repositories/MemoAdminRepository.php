<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\MemoAdmin;

class MemoAdminRepository extends AbstractRepository
{
    public function model()
    {
        return MemoAdmin::class;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getCurrent()
    {
        return $this->model->where('off_date', '<=', 'CURDATE()')->get();
    }
}
