<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class UserSignature extends Model
{
	protected $table = 'dental_user_signatures';

	protected $fillable = ['user_id', 'signature_json', 'ip_address'];

	protected $primaryKey = 'id';

	public static function get($userId)
	{
		$userSignature = UserSignature::where('user_id', '=', $userId)->get();

		return $userSignature;
	}
}