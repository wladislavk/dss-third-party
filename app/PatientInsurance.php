<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class PatientInsurance extends Model
{
	protected $table = 'dental_patient_insurance';

	protected $fillable = ['patientid', 'insurancetype', 'company'];

	protected $primaryKey = 'id';

	public static function get($docId, $valuesWhere)
	{
		$patientInsurance = DB::table('dental_patient_insurance')->join('dental_patients', 'dental_patients.patientid', '=', 'dental_patient_insurance.patientid');

		foreach ($valuesWhere as $key => $value) {
			$patientInsurance = $patientInsurance->where($key, '=', $value);
		}										   

		return $patientInsurance->get();
	}
}