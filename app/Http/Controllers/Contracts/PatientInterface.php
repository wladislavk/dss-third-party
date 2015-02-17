<?php namespace Ds3\Contracts;

interface PatientInterface
{
	public function get($where, $orders = null);

	public function getLogins($clogin);

	public function getJoinPatients($where, $join);

	public function getPendingDuplicates($where, $status = null, $order = null);

	public function getTransactionCode0486($patientId);

	public function getUserInfo($patientId);

	public function preauthPatient($patientId);

	public function getSimilarPatients($data);

	public function insertData($data);

	public function updateData($where, $values);

	public function deleteData($where);
}