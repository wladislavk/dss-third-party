<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use League\Fractal\TransformerAbstract;

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
