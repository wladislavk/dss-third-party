<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportCategory;
use Prettus\Repository\Eloquent\BaseRepository;

class SupportCategoryRepository extends BaseRepository
{
    public function model()
    {
        return SupportCategory::class;
    }
}
