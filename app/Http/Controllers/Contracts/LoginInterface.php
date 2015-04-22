<?php
namespace Ds3\Contracts;

interface LoginInterface
{
    public function insertData($data);
    public function getLogins($where);
    public function updateData($loginId, $values);
}
