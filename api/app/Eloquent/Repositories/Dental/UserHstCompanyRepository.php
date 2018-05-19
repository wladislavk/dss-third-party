<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\UserHstCompany;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class UserHstCompanyRepository extends AbstractRepository
{
    public function model()
    {
        return UserHstCompany::class;
    }
}
