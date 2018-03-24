<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

class IntegerTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        return 'integer';
    }
}
