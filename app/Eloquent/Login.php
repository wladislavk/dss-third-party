<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Login extends Model
{
	protected $table = 'dental_login';

	protected $fillable = ['docid', 'userid', 'login_date'];

	protected $primaryKey = 'loginid';

	public static function insert($data)
	{
		$login = new Login();

		foreach ($data as $attribute => $value) {
			$login->$attribute = $value;
		}

		try {
			$login->save();
		} catch(QueryException $e) {
			return null;
		}

		return $login->loginid;
	}

	public static function get($where)
	{
		$login = new Login();

		foreach ($where as $attribute => $value) {
			$login = $login->where($attribute, '=', $value);
		}

		return $login->get();
	}
}