<?php namespace Ds3\Contracts;

interface FaxInterface
{
	public function getFaxAlerts($docId);

	public function updateData($where, $values);
}