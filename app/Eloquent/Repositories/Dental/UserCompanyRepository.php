<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class UserCompanyRepository extends BaseRepository
{
    public function model()
    {
        return UserCompany::class;
    }
}
