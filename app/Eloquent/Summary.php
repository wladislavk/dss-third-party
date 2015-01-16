<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Summary extends Model
{
	protected $table = 'dental_summary';

	protected $fillable = ['formid', 'patientid', 'patient_name'];

	protected $primaryKey = 'summaryid';

	public static function get($patientId)
	{
		try {
			$location = Summary::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $location;
	}

	public static function updateData($patientId, $values)
	{
		$summary = Summary::where('patientid', '=', $patientId)->update($values);

		return $summary;
	}

	public static function insertData($data)
	{
		$summary = new Summary();

		foreach ($data as $attribute => $value) {
			$summary->$attribute = $value;
		}

		try {
			$summary->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $summary->summaryid;
	}
}