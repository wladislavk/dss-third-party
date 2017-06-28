<?php

namespace DentalSleepSolutions\Swagger\ModelTransformers;

use DentalSleepSolutions\Swagger\TransformerInterface;

abstract class AbstractModelTransformer implements TransformerInterface
{
    public function transform($name, $type)
    {
        $transformed = [];
        return $transformed;
    }
}
