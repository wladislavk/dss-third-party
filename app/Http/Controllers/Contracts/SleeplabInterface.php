<?php
namespace Ds3\Contracts;

interface SleeplabInterface
{
    public function getSleeplabs($where, $order = null);
    public function updateData($sleeplabId, $values);
    public function insertData($data);
}
