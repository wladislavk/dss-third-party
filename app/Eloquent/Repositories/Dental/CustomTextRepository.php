<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomText;
use Prettus\Repository\Eloquent\BaseRepository;

class CustomTextRepository extends BaseRepository
{
    public function model()
    {
        return CustomText::class;
    }
}
