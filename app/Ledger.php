<?php namespace Ds3;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Ledger extends Model
{
	protected $table = 'dental_ledger';

	protected $fillable = ['patientid', 'description', 'transaction_type', 'paid_amount', 'userid', 'docid', 'status'];

	protected $primaryKey = 'ledgerid';

	public static function getPendingClaims($docId, $valuesWhere)
	{
		$pendingClaims = DB::table('dental_ledger')->join('dental_transaction_code', 'dental_transaction_code.transaction_code', '=', 'dental_ledger.transaction_code')
												   ->join('dental_users', 'dental_users.userid', '=', 'dental_ledger.docid')
												   ->join('dental_patients', 'dental_patients.patientid', '=', 'dental_ledger.patientid');

		foreach ($valuesWhere as $key => $value) {
			$pendingClaims = $pendingClaims->where($key, '=', $value);
		}

		$pendingClaims = $pendingClaims->distinct()
									   ->get();

		return $pendingClaims;
	}
}