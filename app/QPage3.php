<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class QPage3 extends Model
{
	protected $table = 'dental_q_page3';

	protected $fillable = ['formid', 'patientid', 'allergens'];

	protected $primaryKey = 'q_page3id';

	public static function getValues($patientId, $values)
	{
		try {
			$qPage3 = QPage3::where('patientid', '=', $patientId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		foreach ($values as $value) {
			$returnedValues[$value] = $qPage3[$value];
		}

		return $returnedValues;
	}
}