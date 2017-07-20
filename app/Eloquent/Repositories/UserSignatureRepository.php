<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\UserSignature;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSignatureRepository extends BaseRepository
{
    public function model()
    {
        return UserSignature::class;
    }
}
