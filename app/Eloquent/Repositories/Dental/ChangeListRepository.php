<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ChangeList;
use Prettus\Repository\Eloquent\BaseRepository;

class ChangeListRepository extends BaseRepository
{
    public function model()
    {
        return ChangeList::class;
    }
}
