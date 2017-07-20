<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ImageType;
use Prettus\Repository\Eloquent\BaseRepository;

class ImageTypeRepository extends BaseRepository
{
    public function model()
    {
        return ImageType::class;
    }
}
