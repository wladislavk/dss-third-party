<?php
namespace Ds3\Contracts;

interface TaskInterface
{
    public function getTasks($userId, $docId, $patientId, $task, $type = null, $input = null, $sort = null, $limit = null);
    public function getJoin($id);
    public function updateData($id, $values);
    public function insertData($data);
}
