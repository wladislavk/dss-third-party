<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use Prettus\Repository\Eloquent\BaseRepository;

class ProfileImageRepository extends BaseRepository
{
    public function model()
    {
        return ProfileImage::class;
    }
}
