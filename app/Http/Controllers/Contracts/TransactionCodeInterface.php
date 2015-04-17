<?php
namespace Ds3\Contracts;

interface TransactionCodeInterface
{
    public function deleteData($where);
    public function getTransactionCode($where, $order, $limit, $offset);
    public function updateDataSortby($where);
    public function getPlaceService($where, $order);
    public function getModifierCode($where, $order);
    public function insertData($data);
}
