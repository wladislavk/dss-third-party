<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\AdminCompany;

class AdminCompanyRepository extends AbstractRepository
{
    public function model()
    {
        return AdminCompany::class;
    }
}
