<?php namespace Ds3\Contracts;

interface SummaryInterface
{
	public function get($patientId);

	public function updateData($where, $values);

	public function insertData($data);
}