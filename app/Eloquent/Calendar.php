<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
	protected $table = 'dental_calendar';

	protected $fillable = ['start_date', 'end_date', 'description', 'event_id', 'docid'];

	protected $primaryKey = 'id';

	public static function getJoin($where)
	{
		$calendar = DB::table(DB::raw('dental_calendar as dc'))->select(DB::raw('dc.*, dp.*, dt.name as etype'))
															   ->leftJoin(DB::raw('dental_patients as dp'), 'dc.patientid', '=', 'dp.patientid')
															   ->join(DB::raw('dental_appt_types as dt'), 'dc.category', '=', 'dt.classname');

		foreach ($where as $attribute => $value) {
			$calendar = $calendar->where($attribute, '=', $value);
		}

		$calendar = $calendar->orderBy('dc.id')
							 ->get();

		return $calendar;
	}

	public static function updateData($where, $values)
	{
		$calendar = new Calendar();

		foreach ($where as $attribute => $value) {
			$calendar->where($attribute, '=', $value);
		}

		$calendar->update($values);
	}
}