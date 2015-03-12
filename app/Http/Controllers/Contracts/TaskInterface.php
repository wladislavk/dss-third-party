<?php namespace Ds3\Contracts;

interface TaskInterface
{
    public function get($userId, $docId, $patientId, $task, $type = null, $input = null);
    public function getJoin($id);
    public function updateData($id, $values);
    public function insertData($data);
}
