<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Recipient;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class RecipientRepository extends AbstractRepository
{
    public function model()
    {
        return Recipient::class;
    }
}
