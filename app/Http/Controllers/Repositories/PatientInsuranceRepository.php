<?php namespace Ds3\Repositories;

use Ds3\Contracts\PatientInsuranceInterface;
use Ds3\Eloquent\Patient\PatientInsurance;

class PatientInsuranceRepository implements PatientInsuranceInterface
{
	public function get($where)
	{
		$patientInsurance = PatientInsurance::join('dental_patients', 'dental_patients.patientid', '=', 'dental_patient_insurance.patientid');

		foreach ($where as $key => $value) {
			$patientInsurance = $patientInsurance->where($key, '=', $value);
		}										   

		return $patientInsurance->get();
	}
}