<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
	protected $table = 'dental_history';

	protected $fillable = ['history', 'description', 'sortby', 'status'];

	protected $primaryKey = 'historyid';

	public static function get($historyId)
	{
		try {
			$history = History::where('historyid', '=', $historyId)->where('status', '=', 1)
																   ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $history;
	}
}