<?php

namespace DentalSleepSolutions\Http\Transformers;

use League\Fractal\TransformerAbstract;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Transformers\TransformerInterface;

abstract class BaseTransformer extends TransformerAbstract implements TransformerInterface
{
    public function transform(Resource $resource)
    {
        return $resource->toArray();
    }

    public function fromTransform(array $data)
    {
        return $data;
    }
}
