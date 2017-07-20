<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalCompanyRepository extends BaseRepository
{
    public function model()
    {
        return ExternalCompany::class;
    }
}
