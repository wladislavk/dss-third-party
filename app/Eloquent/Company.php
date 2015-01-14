<?php namespace Ds3\Eloquent;

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

	public static function getBilling($docId)
	{
		$billing = DB::table(DB::raw('companies c'))->join(DB::raw('dental_users u'), 'c.id', '=', 'u.billing_company_id')
													->where('u.userid', '=', $docId)
													->first();

		return $billing;
	}

	public static function getJoin($userId, $companyType)
	{
		$companies = DB::table(DB::raw('companies h'))->select(DB::raw('h.*, uhc.id as uhc_id'))
													->join(DB::raw('dental_user_hst_company uhc'), function($join) use ($userId){
														$join->on('uhc.companyid', '=', 'h.id')
															 ->where('uhc.userid', '=', $userId);
													}) 
													->where('h.company_type', '=', $companyType)
													->orderBy('name')
													->get();

		return $companies;												
	}
}