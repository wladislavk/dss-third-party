<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ExternalUser;
use Prettus\Repository\Eloquent\BaseRepository;

class ExternalUserRepository extends BaseRepository
{
    public function model()
    {
        return ExternalUser::class;
    }
}
