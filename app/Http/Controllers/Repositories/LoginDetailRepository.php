<?php
namespace Ds3\Repositories;

use Ds3\Contracts\LoginDetailInterface;
use Ds3\Eloquent\Login\LoginDetail;

class LoginDetailRepository implements LoginDetailInterface
{
    public function insertData($data)
    {
        $loginDetail = new LoginDetail();

        foreach ($data as $attribute => $value) {
            $loginDetail->$attribute = $value;
        }

        $loginDetail->save();

        return $loginDetail->l_detailid;
    }
}
