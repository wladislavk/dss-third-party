<?php namespace Ds3\Contracts;

interface PatientInterface
{
	public function get($where, $orders = null);

	public function getLogins($clogin);

	public function getJoinPatients($docId);

	public function getPendingDuplicates($docId);

	public function insertData($data);

	public function updateData($where, $values);
}