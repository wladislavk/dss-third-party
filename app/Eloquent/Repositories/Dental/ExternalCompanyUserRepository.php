<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompanyUser;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalCompanyUserRepository extends BaseRepository
{
    public function model()
    {
        return ExternalCompanyUser::class;
    }
}
