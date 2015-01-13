<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Ledger extends Model
{
	protected $table = 'dental_ledger';

	protected $fillable = ['patientid', 'description', 'transaction_type', 'paid_amount', 'userid', 'docid', 'status'];

	protected $primaryKey = 'ledgerid';

	public $timestamps = false;

	public static function get($id)
	{
		try {
			$ledger = Ledger::where('ledgerid', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $ledger;
	}

	public static function getClaim($primaryClaimId)
	{
		$ledgers = Ledger::where('primary_claim_id', '=', $primaryClaimId)->get();

		return $ledgers;
	}

	public static function getNumTransactions($id)
	{
		try {
			$numTrxn = Ledger::select(DB::raw('COUNT(*) as num_trxn'))->where('primary_claim_id', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $numTrxn;
	}

	public static function getSum($patientId)
	{
		try {
			$ledger = Ledger::select(DB::raw('sum(amount) as amt, sum(paid_amount) as p_amt'))->where('patientid', '=', $patientId)
																						  	  ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $ledger;
	}

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

	public static function insertData($data)
	{
		$ledger = new Ledger();

		foreach ($data as $attribute => $value) {
			$ledger->$attribute = $value;
		}

		try {
			$ledger->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $ledger->ledgerid;
	}

	public static function updateData($id, $values)
	{
		$ledger = Ledger::where('ledgerid', '=', $id)->update($values);

		return $ledger;
	}
}