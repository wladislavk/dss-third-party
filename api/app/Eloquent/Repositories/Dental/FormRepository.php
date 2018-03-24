<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\Form;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class FormRepository extends AbstractRepository
{
    public function model()
    {
        return Form::class;
    }
}
