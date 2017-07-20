<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CorporateContact;
use Prettus\Repository\Eloquent\BaseRepository;

class CorporateContactRepository extends BaseRepository
{
    public function model()
    {
        return CorporateContact::class;
    }
}
