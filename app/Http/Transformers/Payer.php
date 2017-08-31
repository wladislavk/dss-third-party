<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\Payer as Model;

class Payer extends AbstractTransformer implements TransformerInterface
{
    use WithTransformer;

    /**
     * @param Model $resource
     * @return array
     */
    public function transform(Model $resource)
    {
        return $this->simpleTransform($resource);
    }
}
