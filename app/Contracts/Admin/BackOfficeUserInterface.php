<?php namespace Ds3\Admin\Contracts;

interface BackOfficeUserInterface
{
    public function all();
    public function save($fields);
    public function update($id,$fields);
    public function find($id);
    public function delete($id);
    public function companies();
    public function userCompany($id);
}
