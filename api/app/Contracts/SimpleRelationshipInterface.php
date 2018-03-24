<?php

namespace DentalSleepSolutions\Contracts;

interface SimpleRelationshipInterface
{
    /**
     * @param array $data
     * @param bool  $export
     * @param array $initialState
     * @return array
     */
    public function simpleMapping(array $data, $export, array $initialState = []);
}
