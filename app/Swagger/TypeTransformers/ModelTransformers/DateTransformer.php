<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\ModelTransformers;

class DateTransformer extends AbstractModelTransformer
{
    protected function getType($rule)
    {
        return 'string';
    }

    protected function addFormat()
    {
        return 'dateTime';
    }
}
