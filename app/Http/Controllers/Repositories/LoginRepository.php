<?php
namespace Ds3\Repositories;

use Ds3\Contracts\LoginInterface;
use Ds3\Eloquent\Login\Login;

class LoginRepository implements LoginInterface
{
    public function insertData($data)
    {
        $login = new Login();

        foreach ($data as $attribute => $value) {
            $login->$attribute = $value;
        }

        $login->save();

        return $login->loginid;
    }

    public function getLogins($where)
    {
        $login = new Login();

        foreach ($where as $attribute => $value) {
            $login = $login->where($attribute, '=', $value);
        }

        return $login->get();
    }

    public function updateData($loginId, $values)
    {
        $login = Login::where('loginid', '=', $loginId)->update($values);

        return $login;
    }
}
