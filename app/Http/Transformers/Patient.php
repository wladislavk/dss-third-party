<?php

namespace DentalSleepSolutions\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;

class Patient extends TransformerAbstract
{
    /**
     * @param Collection|\DentalSleepSolutions\Eloquent\Models\Dental\Patient $patient
     * @return array
     */
    public function transform($patient)
    {
        $attributes = array_keys($patient->toArray());

        if (in_array('display_alert', $attributes) && empty($patient->display_alert)) {
            $patient->display_alert = 0;
        }

        return $patient->toArray();
    }
}
