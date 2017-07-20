<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ReferredByContact;
use Prettus\Repository\Eloquent\BaseRepository;

class ReferredByContactRepository extends BaseRepository
{
    public function model()
    {
        return ReferredByContact::class;
    }
}
