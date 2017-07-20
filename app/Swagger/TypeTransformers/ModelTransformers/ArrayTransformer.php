<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

class ArrayTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }
}
