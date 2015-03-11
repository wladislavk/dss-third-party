<?php namespace Ds3\Contracts;

interface ContactInterface
{
	public function get($where);

	public function getInsContact($docId);

	public function getContactTypeHolder($where, $letter = null, $order = null, $limit = null, $offset = null);

	public function searchContacts($names, $partial, $docId);

	public function updateData($contactId, $values);

	public function insertData($data);

	public function deleteData($contactId);

	public function getNewContacts($docId);

	public function getDocsleep($contactId);

	public function getPatientContacts($patientId);
}