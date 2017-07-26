<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

class StringTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }
}
