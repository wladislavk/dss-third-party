<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomLetterTemplate;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class CustomLetterTemplateRepository extends AbstractRepository
{
    public function model()
    {
        return CustomLetterTemplate::class;
    }
}
