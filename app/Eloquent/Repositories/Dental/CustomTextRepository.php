<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomText;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class CustomTextRepository extends AbstractRepository
{
    public function model()
    {
        return CustomText::class;
    }
}
