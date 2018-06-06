<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportCategory;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class SupportCategoryRepository extends AbstractRepository
{
    public function model()
    {
        return SupportCategory::class;
    }
}
