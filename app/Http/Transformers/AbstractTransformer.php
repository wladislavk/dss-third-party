<?php

namespace DentalSleepSolutions\Http\Transformers;

use League\Fractal\TransformerAbstract;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\TransformerInterface;

abstract class AbstractTransformer extends TransformerAbstract implements TransformerInterface
{
    public function simpleTransform(AbstractModel $resource)
    {
        return $resource->toArray();
    }

    public function inverseTransform(array $data)
    {
        return $data;
    }
}
