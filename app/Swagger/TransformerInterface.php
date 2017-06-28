<?php

namespace DentalSleepSolutions\Swagger;

interface TransformerInterface
{
    /**
     * @param string $name
     * @param string $type
     * @return array
     */
    public function transform($name, $type);
}
