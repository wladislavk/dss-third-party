<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LetterTemplate;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class LetterTemplateRepository extends AbstractRepository
{
    public function model()
    {
        return LetterTemplate::class;
    }
}
