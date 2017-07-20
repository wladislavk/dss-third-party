<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use Prettus\Repository\Eloquent\BaseRepository;

class ContactRepository extends BaseRepository
{
    public function model()
    {
        return Contact::class;
    }
}
