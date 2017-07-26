<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

class FloatTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        return 'float';
    }
}
