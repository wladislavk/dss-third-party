<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomLetterTemplate;
use Prettus\Repository\Eloquent\BaseRepository;

class CustomLetterTemplateRepository extends BaseRepository
{
    public function model()
    {
        return CustomLetterTemplate::class;
    }
}
