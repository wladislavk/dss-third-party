<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\AdminCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class AdminCompanyRepository extends BaseRepository
{
    public function model()
    {
        return AdminCompany::class;
    }
}
