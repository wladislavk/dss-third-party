<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\TransactionType;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class TransactionTypeRepository extends AbstractRepository
{
    public function model()
    {
        return TransactionType::class;
    }
}
