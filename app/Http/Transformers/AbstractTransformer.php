<?php

namespace DentalSleepSolutions\Http\Transformers;

use DentalSleepSolutions\Contracts\TransformerInterface;
use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use League\Fractal\TransformerAbstract;

abstract class AbstractTransformer extends TransformerAbstract implements TransformerInterface
{
    /**
     * @param AbstractModel $resource
     * @return array
     */
    public function simpleTransform(AbstractModel $resource)
    {
        return $resource->toArray();
    }

    /**
     * @param array $data
     * @return array
     */
    public function inverseTransform(array $data)
    {
        return $data;
    }
}
