<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
	protected $table = 'dental_summary';

	protected $fillable = ['formid', 'patientid', 'patient_name'];

	protected $primaryKey = 'summaryid';

	public static function get($patientId)
	{
		$summary = Summary::where('patientid', '=', $patientId)->get();

		return $summary;
	}

	public static function updateData($where, $values)
	{
		$summary = new Summary();

		foreach ($where as $attribute => $value) {
			$summary = $summary->where($attribute, '=', $value);
		}

		$summary = $summary->update($values);

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