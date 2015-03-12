<?php namespace Ds3\Contracts;

interface FlowPg2Interface
{
    public function getStep($patientId);
    public function updateData($patientId, $values);
}
