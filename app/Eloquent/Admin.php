<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Admin extends Model
{
	protected $table = 'dental_support_tickets';

	protected $fillable = ['title', 'userid', 'docid', 'body', 'category_id'];

	protected $primaryKey = 'id';

	public static function getJoin($categoryId)
	{
		$admin = DB::table(DB::raw('admin a'))->select('a.*')
											  ->join(DB::raw('dental_support_category_admin ca'), 'ca.adminid', '=', 'a.adminid')
											  ->where('ca.category_id', '=', $categoryId)
											  ->get();

		return $admin;
	}
}