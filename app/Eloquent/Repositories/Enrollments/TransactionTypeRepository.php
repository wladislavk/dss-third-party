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

    /**
     * @param int $id
     * @return TransactionType|null
     */
    public function findWithStatusOne($id)
    {
        return $this->model
            ->where('id', $id)
            ->where('status', 1)
            ->first();
    }
}
