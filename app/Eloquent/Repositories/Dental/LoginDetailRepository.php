<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LoginDetail;
use Prettus\Repository\Eloquent\BaseRepository;

class LoginDetailRepository extends BaseRepository
{
    public function model()
    {
        return LoginDetail::class;
    }
}
