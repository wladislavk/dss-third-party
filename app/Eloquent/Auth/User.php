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

    private $first_name;
    private $last_name;

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

	public static function getLocation($where, $defaultLocation = null)
	{
		$location = DB::table(DB::raw('dental_users u'))->select(DB::raw('l.phone mailing_phone, u.user_type, u.logo, l.location mailing_practice, l.address mailing_address, l.city mailing_city, l.state mailing_state, l.zip mailing_zip'))
														->join(DB::raw('dental_patients p'), 'u.userid', '=', 'p.docid');

		if (!empty($defaultLocation)) {
			$location = $location->leftJoin(DB::raw('dental_locations l'), function($join){
									$join->on('l.docid', '=', 'u.userid')
										 ->where('l.default_location', '=', '1');
								 });
		} else {
			$location = $location->leftJoin(DB::raw('dental_locations l'), 'l.docid', '=', 'u.userid');
		}

		foreach ($where as $attribute => $value) {
			$location = $location->where($attribute, '=', $value);
		}
														
		return $location->first();
	}

	public static function isUniqueField($field, $userId)
	{
		reset($field);
		$attribute = key($field);
		$value = $field[$attribute];

		$user = User::where($attribute, '=', $value)->where('userid', '!=', $userId);							

		return $user->get();
	}

	public static function getResponsible($userId, $docId)
	{
		$responsible = User::where('status', '=', 1)->where(function($query) use ($userId, $docId){
														$query->where('userid', '=', $userId)
															  ->orWhere('docid', '=', $docId);
													})
													->get();

		return $responsible;
	}

	public static function updateData($userId, $values)
	{
		$user = User::where('userid', '=', $userId)->update($values);

		return $user;
	}

	public static function insertData($data)
	{
		$user = new User();

		foreach ($data as $attribute => $value) {
			$user->$attribute = $value;
		}

		try {
			$user->save();
		} catch (QueryException $e) {
			return null;
		}

		return $user->userid;
	}
}
