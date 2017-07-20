<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use Prettus\Repository\Eloquent\BaseRepository;

class ContactTypeRepository extends BaseRepository
{
    public function model()
    {
        return ContactType::class;
    }
}
