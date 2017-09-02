<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class Payer extends AbstractTransformer implements TransformerInterface
{
    use WithTransformer;

    /**
     * @param AbstractModel $resource
     * @return array
     */
    public function transform(AbstractModel $resource)
    {
        return $this->simpleTransform($resource);
    }
}
