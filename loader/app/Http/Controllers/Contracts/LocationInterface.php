<?php
namespace Ds3\Contracts;

interface LocationInterface
{
    public function findLocation($id);
    public function getLocations($where);
    public function updateData($id, $values);
    public function insertData($data);
}
