<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class PatientContact extends Model
{
	protected $table = 'dental_patient_contacts';

	protected $fillable = ['patientid', 'firstname', 'lastname'];

	protected $primaryKey = 'id';

	public static function get($docId, $valuesWhere)
	{
		$patientContact = DB::table('dental_patient_contacts')->join('dental_patients', 'dental_patients.patientid', '=', 'dental_patient_contacts.patientid');

		foreach ($valuesWhere as $key => $value) {
			$patientContact = $patientContact->where($key, '=', $value);
		}												   

		return $patientContact->get();
	}

/*
	public function patient()
	{
		return $this->hasMany('Ds3\Patient', 'patientid');
	}
*/
}