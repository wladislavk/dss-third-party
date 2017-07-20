<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Enrollments;

use DentalSleepSolutions\Eloquent\Models\Enrollments\Enrollment;
use Prettus\Repository\Eloquent\BaseRepository;

class EnrollmentRepository extends BaseRepository
{
    public function model()
    {
        return Enrollment::class;
    }
}
