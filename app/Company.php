<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Company extends Model
{
	protected $table = 'companies';

	protected $fillable = ['name', 'status'];

	protected $primaryKey = 'id';

	public static function getLogo($userId)
	{
		$logo = DB::table(DB::raw('companies c'))->select(DB::raw('c.logo'))
												 ->join(DB::raw('dental_user_company uc'), 'uc.companyid', '=', 'c.id')
												 ->where('uc.userid', '=', $userId)
												 ->first();

		return $logo;
	}
}