<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient as Resource;

class Patient extends BaseTransformer implements TransformerInterface
{
    use WithTransformer;

    /**
     * @param Resource $patient
     * @return array
     */
    public function transform(Resource $patient)
    {
        $attributes = array_keys($patient->toArray());

        if (in_array('display_alert', $attributes) && empty($patient->display_alert)) {
            $patient->display_alert = 0;
        }

        return $patient->toArray();
    }
}
