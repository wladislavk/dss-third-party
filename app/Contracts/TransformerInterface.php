<?php

namespace DentalSleepSolutions\Contracts;

interface TransformerInterface
{
    public function inverseTransform(array $data);
}
