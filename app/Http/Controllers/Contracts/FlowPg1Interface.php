<?php
namespace Ds3\Contracts;

interface FlowPg1Interface
{
    public function find($patientId);
    public function updateData($id, $values);
    public function insertData($data);
}
