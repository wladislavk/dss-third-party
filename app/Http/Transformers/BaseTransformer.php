<?php

namespace DentalSleepSolutions\Http\Transformers;

use League\Fractal\TransformerAbstract;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\TransformerInterface;

abstract class BaseTransformer extends TransformerAbstract implements TransformerInterface
{
    public function simpleTransform(AbstractModel $resource)
    {
        return $resource->toArray();
    }

    public function fromTransform(array $data)
    {
        return $data;
    }
}
