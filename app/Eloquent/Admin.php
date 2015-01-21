<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Admin extends Model
{
	protected $table = 'admin';

	protected $fillable = ['name', 'username', 'password', 'status'];

	protected $primaryKey = 'adminid';

	public static function get($adminId)
	{
		try {
			$admin = Admin::where('adminid', '=', $adminId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $admin;
	}

	public static function getJoin($categoryId)
	{
		$admin = DB::table(DB::raw('admin a'))->select('a.*')
											  ->join(DB::raw('dental_support_category_admin ca'), 'ca.adminid', '=', 'a.adminid')
											  ->where('ca.category_id', '=', $categoryId)
											  ->get();

		return $admin;
	}
}