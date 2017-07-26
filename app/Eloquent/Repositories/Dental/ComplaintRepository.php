<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Complaint;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ComplaintRepository extends AbstractRepository
{
    public function model()
    {
        return Complaint::class;
    }
}
