<?php namespace Ds3\Contracts;

interface FlowPg2InfoInterface
{
    public function get($where, $order = null);
    public function insertData($data);
    public function updateData($patientId, $values);
}
