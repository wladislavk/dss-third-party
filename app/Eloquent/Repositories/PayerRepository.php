<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Payer;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;

class PayerRepository extends BaseRepository
{
    public function model()
    {
        return Payer::class;
    }

    /**
     * @param int $uid
     * @return Payer|Builder|null
     */
    public function findByUid($uid)
    {
        return $this->model->query()->where('payer_id', $uid)->first();
    }
}
