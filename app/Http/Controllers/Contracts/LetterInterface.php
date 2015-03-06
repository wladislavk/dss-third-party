<?php namespace Ds3\Contracts;

interface LetterInterface
{
	public function get($where, $order = null);

	public function getList($letterId, $parentId);

	public function getMdList($contact, $letter1id, $letter2id);

	public function getGeneratedDates($valuesWhere);

	public function getUnmailedLetters($docId);

	public function getJoin($patientId, $infoId);

	public function getPendingLetters($docId, $patientId);

	public function getContactLetters($contact, $where);

	public function getContactSentLetters($delivered, $contactId);

	public function updateData($where, $values);

	public function insertData($data);
}