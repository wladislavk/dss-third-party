<?php
namespace Ds3\Contracts;

interface CustomInterface
{
    public function deleteData($data);
    public function getCustomTypeHolder($where, $order, $limit, $offset);
    public function updateData($customId, $values);
    public function insertData($data);
}
