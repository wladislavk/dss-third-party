<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QSleep extends Model
{
	protected $table = 'dental_q_sleep';

	protected $fillable = ['formid', 'patientid', 'userid', 'docid', 'status'];

	protected $primaryKey = 'q_sleepid';

	public static function get($patientId)
	{
		try {
			$qSleep = QSleep::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $qSleep;
	}
}