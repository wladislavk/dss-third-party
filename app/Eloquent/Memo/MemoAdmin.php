<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MemoAdmin extends Model
{
	protected $table = 'memo_admin';

	protected $fillable = ['memo', 'off_date'];

	protected $primaryKey = 'memo_id';

	public static function get()
	{
		$memoAdmins = MemoAdmin::whereRaw('off_date <= CURDATE()')->get();

		return $memoAdmins;
	}
}