<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\UserHstCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class UserHstCompanyRepository extends BaseRepository
{
    public function model()
    {
        return UserHstCompany::class;
    }
}
