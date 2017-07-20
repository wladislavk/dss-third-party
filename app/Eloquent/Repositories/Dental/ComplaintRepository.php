<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Complaint;
use Prettus\Repository\Eloquent\BaseRepository;

class ComplaintRepository extends BaseRepository
{
    public function model()
    {
        return Complaint::class;
    }
}
