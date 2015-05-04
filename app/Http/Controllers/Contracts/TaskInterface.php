<?php
namespace Ds3\Contracts;

interface TaskInterface
{
    public function getTasks($parameters);
    public function getJoin($id);
    public function updateData($id, $values);
    public function insertData($data);
}
