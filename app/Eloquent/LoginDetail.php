<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class LoginDetail extends Model
{
	protected $table = 'dental_login_detail';

	protected $fillable = ['loginid', 'userid', 'cur_page'];

	protected $primaryKey = 'l_detailid';

	public static function insert($data)
	{
		$loginDetail = new LoginDetail();

		foreach ($data as $attribute => $value) {
			$loginDetail->$attribute = $value;
		}

		try {
			$loginDetail->save();
		} catch(QueryException $e) {
			return null;
		}

		return $loginDetail->l_detailid;
	}
}