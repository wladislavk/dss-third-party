<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LoginDetail;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LoginDetailRepository extends AbstractRepository
{
    public function model()
    {
        return LoginDetail::class;
    }
}
