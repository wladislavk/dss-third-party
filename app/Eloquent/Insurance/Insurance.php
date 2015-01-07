<?php namespace Ds3;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Insurance extends Model
{
	protected $table = 'dental_insurance';

	protected $fillable = ['patientid', 'patient_firstname', 'patient_lastname'];

	protected $primaryKey = 'insuranceid';

	public static function get($docId, $status, $valuesWhere)
	{
		$pendingClaims = DB::table('dental_insurance')->whereRaw('(status IN (' . $status . '))');

		foreach ($valuesWhere as $key => $value) {
			$pendingClaims = $pendingClaims->where($key, '=', $value);
		}													  

		return $pendingClaims->get();
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
}