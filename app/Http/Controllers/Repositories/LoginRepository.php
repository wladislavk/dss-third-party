<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

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

		try {
			$login->save();
		} catch(ModelNotFoundException $e) {
			return null;
		}

		return $login->loginid;
	}


	public function get($where)
	{
		$login = new Login();

		foreach ($where as $attribute => $value) {
			$login = $login->where($attribute, '=', $value);
		}

		return $login->get();
	}
}