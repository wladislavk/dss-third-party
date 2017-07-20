<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Payer;
use Prettus\Repository\Eloquent\BaseRepository;

class PayerRepository extends BaseRepository
{
    public function model()
    {
        return Payer::class;
    }
}
