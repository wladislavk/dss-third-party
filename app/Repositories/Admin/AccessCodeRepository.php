<?php namespace Ds3\Admin\Repositories;

use Ds3\Admin\Contracts\AccessCodeInterface;
use Ds3\Eloquent\AccessCode;

class AccessCodeRepository implements AccessCodeInterface
{
    private $accesscode;

    public function __construct(AccessCode $accessCode)
    {
        $this->accesscode = $accessCode;
    }

    public function save($fields)
    {
        if ($this->accesscode->create($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function find($id)
    {
        return $this->accesscode->find($id);
    }

    public function update($fields, $id)
    {
        if ($this->accesscode->find($id)->update($fields)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        if ($this->accesscode->find($id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllAccessCodes()
    {
        return $this->accesscode->orderBy('id', 'DESC');
    }
}
