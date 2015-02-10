<?php namespace Ds3\Contracts;

interface PatientSummaryInterface
{
	public function get($where);

	public function updateData($patientId, $values);

	public function insertData($data);
}