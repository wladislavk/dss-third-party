<?php

namespace DentalSleepSolutions\Contracts;

interface ComplexRelationshipInterface
{
    /**
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function complexMapping(array $data, $export, array $initialState = []);
}
