<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;
use Ds3\Eloquent\Auth\User;


class Admin extends User
{
	protected $table = 'admin';

	protected $fillable = [
        'name',
        'username',
        'password',
        'status',
        'email',
        'first_name',
        'last_name',
        'admin_access'
    ];

	protected $primaryKey = 'adminid';

	public static function getAdmin($adminId)
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
    public function adminCompanies()
    {
        $this->hasMany('Ds3\Eloquent\AdminCompany');
    }
}