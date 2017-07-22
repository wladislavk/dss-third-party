<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\PayersList;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class PayersListRepository extends AbstractRepository
{
    public function model()
    {
        return PayersList::class;
    }
}
