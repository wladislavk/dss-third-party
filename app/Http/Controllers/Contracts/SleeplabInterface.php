<?php
namespace Ds3\Contracts;

interface SleeplabInterface
{
    public function getSleeplabs($where, $order = null);
    public function updateData($sleeplabId, $values);
    public function insertData($data);
    public function deleteData($data);
    public function getSleepLabTypeHolder($where, $letter = null, $order = null, $dir = null, $limit = null, $offset = null);
}
