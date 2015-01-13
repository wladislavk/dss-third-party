<?php namespace Ds3\Eloquent\Insurance;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class InsurancePreauth extends Model
{
	protected $table = 'dental_insurance_preauth';

	protected $fillable = ['doc_id', 'patient_id', 'ins_co'];

	protected $primaryKey = 'id';

	public static function get($wheres, $order = null)
	{
		$insurancePreauth = new InsurancePreauth();

		foreach ($wheres as $attribute => $value) {
			$insurancePreauth = $insurancePreauth->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$insurancePreauth = $insurancePreauth->orderBy($order, 'desc');
		}

		try {
			$insurancePreauth = $insurancePreauth->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $insurancePreauth;
	}

	public static function getViewed($docId, $DSS_PREAUTH_COMPLETE)
	{
		$insurancePreauth = InsurancePreauth::where('doc_id', '=', $docId)->where('status', '=', $DSS_PREAUTH_COMPLETE)
																 		  ->where(function($query){
																 				$query->whereNull('viewed')
																 		  			  ->orWhere('viewed', '!=', 1);
																 		  })
																 		  ->get();

		return $insurancePreauth;
	}

	public static function getPendingPreauth($docId, $DSS_PREAUTH_PENDING)
	{
		$pendingPreauth = InsurancePreauth::where('doc_id', '=', $docId)->where('status', '=', $DSS_PREAUTH_PENDING)->get();

		return $pendingPreauth;
	}

	public static function getRejectedPreauth($docId, $DSS_PREAUTH_REJECTED)
	{
		$rejectedPreauth = InsurancePreauth::where('doc_id', '=', $docId)->where('status', '=', $DSS_PREAUTH_REJECTED)
																		 ->where(function($query){
																		 	$query->whereNull('viewed')
																		 		  ->orWhere('viewed', '!=', 1);
																		 })
																		 ->get();

		return $rejectedPreauth;
	}
}