<?php namespace Ds3\Contracts;

interface ContactInterface
{
	public function get($where);

	public function getInsContact($docId);

	public function updateData($contactId, $values);

	public function insertData($data);

	public function getNewContacts($docId);

	public function getDocsleep($contactId);
}