<?php namespace Ds3\Contracts;

interface SummaryInterface
{
    public function getSummary($patientId);
    public function updateData($where, $values);
    public function insertData($data);
}
