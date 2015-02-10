<?php namespace Ds3\Contracts;

interface FlowPg1Interface
{
	public function get($patientId);

	public function updateData($id, $values);

	public function insertData($data);
}