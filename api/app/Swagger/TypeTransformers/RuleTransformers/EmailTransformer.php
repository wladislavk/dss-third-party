<?php

namespace DentalSleepSolutions\Swagger\TypeTransformers\RuleTransformers;

class EmailTransformer extends StringTransformer
{
    protected function addFormat()
    {
        return 'email';
    }
}
