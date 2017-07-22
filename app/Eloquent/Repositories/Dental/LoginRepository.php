<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Login;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LoginRepository extends AbstractRepository
{
    public function model()
    {
        return Login::class;
    }
}
