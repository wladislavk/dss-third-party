<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\CompanyInterface;
use Ds3\Eloquent\Company;

class CompanyRepository implements CompanyInterface
{
	public function get()
	{
		$companies = Company::select('id')->get();

		return $companies;
	}

	public function getLogo($userId)
	{
		$logo = DB::table(DB::raw('companies c'))
				->select(DB::raw('c.logo'))
				->join(DB::raw('dental_user_company uc'), 'uc.companyid', '=', 'c.id')
				->where('uc.userid', '=', $userId)
				->first();

		return $logo;
	}

	public function getBilling($where, $order = null)
	{
		$billing = DB::table(DB::raw('companies c'))
				->select('c.name', 'c.exclusive')
				->join(DB::raw('dental_users u'), 'c.id', '=', 'u.billing_company_id');

		foreach ($where as $attribute => $value) {
			$billing = $billing->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$billing = $billing->orderBy($order);
		}

		return $billing->get();
	}

	public function getJoin($userId, $companyType)
	{
		$companies = DB::table(DB::raw('companies h'))
					->select(DB::raw('h.*, uhc.id as uhc_id'))
					->join(DB::raw('dental_user_hst_company uhc'), function($join) use ($userId){
						$join->on('uhc.companyid', '=', 'h.id')
							 ->where('uhc.userid', '=', $userId);
					}) 
					->where('h.company_type', '=', $companyType)
					->orderBy('name')
					->get();

		return $companies;												
	}

	// change the function name

	public function getCo($userId)
	{
		$company = DB::table(DB::raw('companies c'))
				->select(DB::raw('c.id, c.name'))
				->join(DB::raw('dental_user_company uc'), 'c.id', '=', 'uc.companyid')
				->join(DB::raw('dental_users u'), 'u.userid', '=', 'uc.userid')
				->where('u.userid', '=', $userId)
				->first();

		return $company;
	}
}