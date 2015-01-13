<?php namespace Ds3\Eloquent\Auth;

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

	public static function get($username, $password)
	{
		$user = DB::table('dental_users')->leftJoin('dental_user_company', 'dental_user_company.userid', '=', 'dental_users.userid')
										 ->select('dental_users.*', 'dental_user_company.companyid')
										 ->where('username', '=', $username)
										 ->where('password', '=', $password)
										 ->whereBetween('status', array(1, 3))
										 ->first();

		return $user;
	}

	public static function getSalt($username)
	{
		try {
			$user = User::where('username', '=', $username)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->salt;
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

	public static function getValues($userId, $values = null)
	{
		try {
			$user = User::where('userid', '=', $userId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		if (!empty($values)) {
			foreach ($values as $value) {
				$returnedValues[$value] = $user[$value];
			}

			return $returnedValues;
		} else {
			return $user;
		}		
	}

	public static function getCourseJoin($userId)
	{
		$courseJoin = DB::table(DB::raw('dental_users s'))->select(DB::raw('s.use_course, d.use_course_staff'))
													  ->join(DB::raw('dental_users d'), 'd.userid', '=', 's.docid')
										 			  ->where('s.userid', '=', $userId)
										 			  ->first();
		
		return $courseJoin;
	}

	public static function getCourse($userId)
	{
		try {
			$user = User::where('userid', '=', $userId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->use_course;
	}

	public static function getUseLetters($docId)
	{
		try {
			$user = User::where('userid', '=', $docId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $user->use_letters;
	}

	public static function getProviderSelect($docId)
	{
		$users = User::whereRaw('(docid = ' . $docId . ' OR userid = ' . $docId . ')')->where('npi', '!=', '')
																					  ->where(function($query){
																					  	$query->where('producer', '=', 1)
																					  		  ->orWhere('docid', '=', 0);
																					  })
																					  ->orderBy('docid')
																					  ->get();

		return $users;
	}

	public static function getProducerOptions($docId)
	{
		$producerOptions = User::where('userid', '=', $docId)->orWhereRaw('(docid = ' . $docId . ' AND producer = 1)')
															 ->get();

		return $producerOptions;
	}

	public static function getCheck($username, $password, $docId)
	{
		$check = User::where('username', '=', $username)->where('password', '=', $password)
														->where('status', '=', 1)
														->whereRaw('(sign_notes = 1 OR userid = ' . $docId . ')')
														->get();

		return $check;
	}
}
