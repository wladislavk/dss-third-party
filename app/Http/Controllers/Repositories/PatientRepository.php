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

	public function getJoinPatients($where, $join)
	{
		$joinPatients = DB::table(DB::raw('dental_patients p2'))
					->join(DB::raw('dental_patients p'), 'p.' . $join[0], '=', 'p2.' . $join[1]);
		
		foreach ($where as $attribute => $value) {
			$joinPatients = $joinPatients->where($attribute, '=', $value);
		}					

		return $joinPatients->get();
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

	public function getTransactionCode0486($patientId)
	{
		$transactionCodes = DB::table(DB::raw('dental_patients p'))
						->select('tc.*')
						->join(DB::raw('dental_transaction_code tc'), function($join){
							$join->on('p.docid', '=', 'tc.docid')
								 ->where('tc.transaction_code', '=', 'E0486');
						})
						->where('p.patientid', '=', $patientId)
						->get();

		return $transactionCodes;
	}

	public function getUserInfo($patientId)
	{
		$userInfo = DB::table(DB::raw('dental_patients p'))
				->select('u.*')
				->join(DB::raw('dental_users u'), 'p.docid', '=', 'u.userid')
				->where('p.patientid', '=', $patientId)
				->where('u.npi', '!=', '')
				->whereNotNull('u.npi')
				->where('u.tax_id_or_ssn', '!=', '')
				->whereNotNull('u.tax_id_or_ssn')
				->whereRaw('(u.ssn = 1 OR u.ein = 1)')
				->get();

		return $userInfo;
	}

	public function preauthPatient($patientId)
	{
		$patient = DB::table(DB::raw('dental_patients p'))
				->leftJoin(DB::raw('dental_contact r'), 'p.referred_by', '=', 'r.contactid')
				->join(DB::raw('dental_contact i'), 'p.p_m_ins_co', '=', 'i.contactid')
				->join(DB::raw('dental_users d'), 'p.docid', '=', 'd.userid')
				->join(DB::raw('dental_transaction_code tc'), function($join){
					$join->on('p.docid', '=', 'tc.docid')
						 ->where('tc.transaction_code', '=', 'E0486');
				})
				->leftJoin(DB::raw('dental_q_page2 q2'), 'p.patientid', '=', 'q2.patientid')
				->where('p.patientid', '=', $patientId)
				->get();

		return $patient;
	}

	public function getSimilarPatients($data)
	{
		$patients = Patient::where('patientid', '!=', $data['patientId'])
				->where('status', '=', 1)
				->where('docid', '=', $data['docId'])
				->where(function($query) use ($data){
					$query->where(function($query) use ($data){
						$query->where('firstname', '=', $data['firstname'])
							  ->where('lastname', '=', $data['lastname']);
					})
					->orWhere(function($query) use ($data){
						$query->where('add1', '=', $data['add1'])
							  ->where('add1', '!=', '')
							  ->where('city', '=', $data['city'])
							  ->where('city', '!=', '')
							  ->where('state', '=', $data['state'])
							  ->where('state', '!=', '')
							  ->where('zip', '=', $data['zip'])
							  ->where('zip', '!=', '');
					});
				})
				->where('docid', '=', $data['docId'])
				->get();

		return $patients;
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