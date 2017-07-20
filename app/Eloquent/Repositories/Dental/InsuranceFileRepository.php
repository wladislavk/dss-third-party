<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceFile;
use Prettus\Repository\Eloquent\BaseRepository;

class InsuranceFileRepository extends BaseRepository
{
    public function model()
    {
        return InsuranceFile::class;
    }
}
