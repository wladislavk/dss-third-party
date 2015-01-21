<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class ChangeList extends Model
{
	protected $table = 'dental_change_list';

	protected $fillable = ['content'];

	protected $primaryKey = 'id';

	public static function getContent()
	{
		try {
			$changeList = ChangeList::select('content')->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $changeList;
	}
}