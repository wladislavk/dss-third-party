<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Login;
use Prettus\Repository\Eloquent\BaseRepository;

class LoginRepository extends BaseRepository
{
    public function model()
    {
        return Login::class;
    }
}
