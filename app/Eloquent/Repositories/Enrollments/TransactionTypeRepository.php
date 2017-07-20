<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\TransactionType;
use Prettus\Repository\Eloquent\BaseRepository;

class TransactionTypeRepository extends BaseRepository
{
    public function model()
    {
        return TransactionType::class;
    }
}
