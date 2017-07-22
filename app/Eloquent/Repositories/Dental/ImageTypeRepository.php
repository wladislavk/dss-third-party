<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ImageType;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ImageTypeRepository extends AbstractRepository
{
    public function model()
    {
        return ImageType::class;
    }
}
