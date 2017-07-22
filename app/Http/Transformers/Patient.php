<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient as Resource;
use League\Fractal\TransformerAbstract;

class Patient extends TransformerAbstract
{
    public function transform(Resource $patient)
    {
        $attributes = array_keys($patient->toArray());

        if (in_array('display_alert', $attributes) && empty($patient->display_alert)) {
            $patient->display_alert = 0;
        }

        return $patient->toArray();
    }
}
