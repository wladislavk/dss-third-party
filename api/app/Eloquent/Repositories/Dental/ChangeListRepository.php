<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ChangeList;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ChangeListRepository extends AbstractRepository
{
    public function model()
    {
        return ChangeList::class;
    }
}
