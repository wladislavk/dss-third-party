<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\PayersList;
use Prettus\Repository\Eloquent\BaseRepository;

class PayersListRepository extends BaseRepository
{
    public function model()
    {
        return PayersList::class;
    }
}
