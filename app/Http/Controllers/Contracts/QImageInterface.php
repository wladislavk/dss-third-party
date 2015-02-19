<?php namespace Ds3\Contracts;

interface QImageInterface
{
	public function get($imageId);

	public function getImage($imageTypeId, $patientId, $order = null);

	public function insertData($data);

	public function updateData($where, $values);
}