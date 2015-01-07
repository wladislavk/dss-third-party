<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Memo extends Model
{
	protected $table = 'memo';

	protected $fillable = ['user_id', 'memo'];

	protected $primaryKey = 'id';

	public static function get($userId)
	{
		$memos = Memo::where('user_id', '=', $userId)->get();

		return $memos;
	}
}