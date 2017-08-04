<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\Payer as Resource;

class Payer extends AbstractTransformer implements TransformerInterface
{
    use WithTransformer;

    /**
     * @param Resource $resource
     * @return array
     */
    public function transform(Resource $resource)
    {
        return $this->simpleTransform($resource);
    }
}
