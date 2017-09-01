<?php

namespace DentalSleepSolutions\Http\Transformers;

use Illuminate\Database\Eloquent\Collection;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient as PatientModel;
use League\Fractal\TransformerAbstract;

class Patient extends TransformerAbstract
{
    /**
     * @param Collection|PatientModel $patient
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
