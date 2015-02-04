<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\PatientInterface;
use Ds3\Eloquent\Patient\Patient;

class PatientRepository implements PatientInterface
{
	public function get($where, $orders = null)
	{
		$patients = new Patient();

		if (!empty($where)) {
			foreach ($where as $key => $value) {
				$patients = $patients->where($key, '=', $value);
			}
		} else {
			return false;
		}

		if (!empty($orders)) {
			foreach ($orders as $value) {
				$patients = $patients->orderBy($value);
			}
		}
		
		return $patients->get();
	}

	public function getLogins($clogin)
	{
		$logins = Patient::select('login')
				->whereRaw("login LIKE '" . $clogin . "%'")
				->get();

		return $logins;
	}

	public function getJoinPatients($docId)
	{
		$joinPatients = DB::table(DB::raw('dental_patients p2'))
					->join(DB::raw('dental_patients p'), 'p.patientid', '=', 'p2.parent_patientid')
					->whereRaw('p.docid = ' . $docId)
					->get();

		return $joinPatients;
	}

	public function getPendingDuplicates($docId)
	{
		$pendingDuplicates = DB::table(DB::raw('dental_patients p'))
							->select('p.*')
							->whereBetween('status', array(3, 4))
							->where('docid', '=', $docId)
							->whereRaw(DB::raw('(SELECT count(*) FROM dental_patients dp WHERE dp.status = 1 AND dp.docid = ' . $docId . ' AND
										((dp.firstname=p.firstname AND dp.lastname=p.lastname) OR (dp.add1 = p.add1 AND dp.city = p.city AND dp.state = p.state AND dp.zip = p.zip))) != 0'))
							->get();

		return $pendingDuplicates;
	}

	public function insertData($data)
	{
		$patient = new Patient();

		foreach ($data as $attribute => $value) {
			$patient->$attribute = $value;
		}

		try {
			$patient->save();
		} catch (QueryException $e) {
			return null;
		}

		return $patient->patientid;
	}

	public function updateData($where, $values)
	{
		$patient = new Patient();

		foreach ($where as $attribute => $value) {
			$patient = $patient->where($attribute, '=', $value);
		}
		
		$patient = $patient->update($values);

		return $patient;
	}
}