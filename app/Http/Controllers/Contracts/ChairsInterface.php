<?php
namespace Ds3\Contracts;

interface ChairsInterface
{
    public function getResource($where, $whereId = null, $order = null, $orderName = null, $limit = null, $offset = null);
    public function updateData($where, $values);
    public function insertData($data);
    public function deleteData($where, $whereId);
}
