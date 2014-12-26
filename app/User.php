<?php namespace Ds3;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'dental_users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password'];

	protected $primaryKey = 'userid';

	public static function getSalt($username)
	{
		try {
			$user = User::where('username', '=', $username)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->salt;
	}

	public static function get($username, $password)
	{
		$user = DB::table('dental_users')->leftJoin('dental_user_company', 'dental_user_company.userid', '=', 'dental_users.userid')
										 ->where('username', '=', $username)
										 ->where('password', '=', $password)
										 ->whereBetween('status', array(1, 3))
										 ->first();

		return $user;
	}

	public static function getType($docId)
	{
		try {
			$user = User::where('userid', '=', $docId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->user_type;
	}
}
