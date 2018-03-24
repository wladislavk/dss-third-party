<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class Patient extends AbstractTransformer implements TransformerInterface
{
    use WithTransformer;

    /**
     * @param AbstractModel $patient
     * @return array
     */
    public function transform(AbstractModel $patient)
    {
        $attributes = array_keys($patient->toArray());

        if (in_array('display_alert', $attributes) && empty($patient->display_alert)) {
            $patient->display_alert = 0;
        }

        return $patient->toArray();
    }
}
