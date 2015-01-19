<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class InsuranceHistory extends Model
{
	protected $table = 'dental_insurance_history';

	protected $fillable = ['formid', 'patientid'];

	protected $primaryKey = 'id';

	public static function get($where)
	{
		$insuranceHistories = new InsuranceHistory();

		foreach ($where as $attribute => $value) {
			$insuranceHistories = $insuranceHistories->where($attribute, '=', $value);
		}

		return $insuranceHistories->get();
	}
}