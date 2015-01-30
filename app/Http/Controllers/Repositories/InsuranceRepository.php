<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\InsuranceInterface;
use Ds3\Eloquent\Insurance\Insurance;

class InsuranceRepository implements InsuranceInterface
{
	public function get($where, $status = null)
	{
		$pendingClaims = new Insurance();

		foreach ($where as $key => $value) {
			$pendingClaims = $pendingClaims->where($key, '=', $value);
		}

		if (!empty($status)) {
			$pendingClaims = $pendingClaims->whereRaw('(status IN (' . $status . '))');
		}							  

		return $pendingClaims->get();
	}

	public function getPendingNodssClaims($docId, $status)
	{
		$pendingNodssClaims = Insurance::join('dental_patients', 'dental_patients.patientid', '=', 'dental_insurance.patientid')
							->where('dental_patients.p_m_dss_file', '=', '2')
							->where('dental_insurance.docid', '=', $docId)
							->whereRaw('(dental_insurance.status IN (' . $status . '))')
							->get();

		return $pendingNodssClaims;
	}

	public function getUnmailedClaims($docId, $DSS_CLAIM_PENDING, $DSS_CLAIM_SEC_PENDING)
	{
		$unmailedClaims = Insurance::where('docid', '=', $docId)
						->whereNull('mailed_date')
						->where('status', '!=', $DSS_CLAIM_PENDING)
						->where('status', '!=', $DSS_CLAIM_SEC_PENDING)
						->get();

		return $unmailedClaims;
	}

	public function getJoin($patientId)
	{
		$insurance = DB::table(DB::raw('dental_insurance i'))
				->select(DB::raw("CONCAT(p.firstname,' ', p.lastname) pat_name, CONCAT(u.first_name, ' ',u.last_name) doc_name"))
				->join(DB::raw('dental_patients p'), 'i.patientid', '=', 'p.patientid')
				->join(DB::raw('dental_users u'), 'u.userid', '=', 'p.docid')
				->where('p.patientid', '=', $patientId)
				->first();

		return $insurance;
	}

	public function updateData($insuranceId, $values)
	{
		$insurance = Insurance::where('insuranceid', '=', $insuranceId)->update($values);

		return $insurance;
	}

	public function insertData($data)
	{
		$insurance = new Insurance();

		foreach ($data as $attribute => $value) {
			$insurance->$attribute = $value;
		}

		try {
			$insurance->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $insurance->insuranceid;
	}

	public function deleteData($insuranceId)
	{
		$insurance = Insurance::where('insuranceid', '=', $insuranceId)->delete();

		return $insurance;
	}
}