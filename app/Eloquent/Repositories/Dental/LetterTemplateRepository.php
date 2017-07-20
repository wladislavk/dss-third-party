<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\LetterTemplate;
use Prettus\Repository\Eloquent\BaseRepository;

class LetterTemplateRepository extends BaseRepository
{
    public function model()
    {
        return LetterTemplate::class;
    }
}
