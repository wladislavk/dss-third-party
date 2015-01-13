<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Calendar extends Model
{
	protected $table = 'dental_calendar';

	protected $fillable = ['start_date', 'end_date', 'description', 'event_id', 'docid'];

	protected $primaryKey = 'id';

	public static function updateData($where, $values)
	{
		$calendar = new Calendar();

		foreach ($where as $attribute => $value) {
			$calendar->where($attribute, '=', $value);
		}

		$calendar->update($values);
	}
}