<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\MemoAdmin;
use Prettus\Repository\Eloquent\BaseRepository;

class MemoAdminRepository extends BaseRepository
{
    public function model()
    {
        return MemoAdmin::class;
    }
}
