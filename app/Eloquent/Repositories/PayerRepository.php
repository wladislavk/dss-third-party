<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Payer;
use Illuminate\Database\Query\Builder;

class PayerRepository extends AbstractRepository
{
    public function model()
    {
        return Payer::class;
    }

    /**
     * @param int $uid
     * @return \Illuminate\Database\Eloquent\Model|Payer|null
     */
    public function findByUid($uid)
    {
        return $this->model->query()->where('payer_id', $uid)->first();
    }
}
