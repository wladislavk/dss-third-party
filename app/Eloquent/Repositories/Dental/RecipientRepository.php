<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Recipient;
use Prettus\Repository\Eloquent\BaseRepository;

class RecipientRepository extends BaseRepository
{
    public function model()
    {
        return Recipient::class;
    }
}
