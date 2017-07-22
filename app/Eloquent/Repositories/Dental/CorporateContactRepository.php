<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CorporateContact;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class CorporateContactRepository extends AbstractRepository
{
    public function model()
    {
        return CorporateContact::class;
    }
}
