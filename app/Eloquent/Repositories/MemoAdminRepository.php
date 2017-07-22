<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\MemoAdmin;

class MemoAdminRepository extends AbstractRepository
{
    public function model()
    {
        return MemoAdmin::class;
    }
}
