<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Insurance extends Model
{
	protected $table = 'dental_insurance';

	protected $fillable = ['patientid', 'patient_firstname', 'patient_lastname'];

	protected $primaryKey = 'insuranceid';

	public static function get($docId, $valuesWhere, $status = null)
	{
		$pendingClaims = new Insurance();

		foreach ($valuesWhere as $key => $value) {
			$pendingClaims = $pendingClaims->where($key, '=', $value);
		}

		if (!empty($status)) {
			$pendingClaims = $pendingClaims->whereRaw('(status IN (' . $status . '))');
		}							  

		return $pendingClaims->get();
	}

	public static function getClaim($insuranceId)
	{
		try {
			$claim = Insurance::where('insuranceid', '=', $insuranceId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $claim;
	}

	public static function getPendingNodssClaims($docId, $input)
	{
		$status = '';
		foreach ($input as $value) {
			$status .= $value . ',';
		}
		$status = substr($status, 0, strlen($status) - 1);

		$pendingNodssClaims = DB::table('dental_insurance')->join('dental_patients', 'dental_patients.patientid', '=', 'dental_insurance.patientid')
														   ->where('dental_patients.p_m_dss_file', '=', '2')
														   ->where('dental_insurance.docid', '=', $docId)
														   ->whereRaw('(dental_insurance.status IN (' . $status . '))')
														   ->get();

		return $pendingNodssClaims;
	}

	public static function getUnmailedClaims($docId, $DSS_CLAIM_PENDING, $DSS_CLAIM_SEC_PENDING)
	{
		$unmailedClaims = DB::table('dental_insurance')->where('docid', '=', $docId)
													   ->whereNull('mailed_date')
													   ->where('status', '!=', $DSS_CLAIM_PENDING)
													   ->where('status', '!=', $DSS_CLAIM_SEC_PENDING)
													   ->get();

		return $unmailedClaims;
	}

	public static function insertData($data)
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

	public static function deleteData($insuranceId)
	{
		$insurance = Insurance::where('insuranceid', '=', $insuranceId)->delete();

		return $insurance;
	}
}