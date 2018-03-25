<?php
namespace Ds3\Admin\Contracts;

interface AccessCodeInterface
{
    public function save($fields);
    public function update($fields, $id);
    public function find($id);
    public function delete($id);
    public function getAllAccessCodes();
}
