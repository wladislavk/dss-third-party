<?php namespace Ds3\Admin\Contracts;

interface PlanInterface
{
    public function all();
    public function save($fields);
    public function find($id);
    public function update($id,$fields);
    public function delete($id);
}
