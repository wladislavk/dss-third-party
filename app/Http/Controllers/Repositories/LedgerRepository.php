<?php namespace Ds3\Repositories;

use Ds3\Contracts\LedgerInterface;
use Ds3\Eloquent\Ledger\Ledger;

class LedgerRepository implements LedgerInterface
{
	public function getClaim($primaryClaimId)
	{
		$ledgers = Ledger::where('primary_claim_id', '=', $primaryClaimId)->get();

		return $ledgers;
	}

	public function getNumTransactions($id)
	{
		try {
			$numTrxn = Ledger::select(DB::raw('COUNT(*) as num_trxn'))->where('primary_claim_id', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $numTrxn;
	}

	public function getSum($patientId)
	{
		try {
			$ledger = Ledger::select(DB::raw('sum(amount) as amt, sum(paid_amount) as p_amt'))->where('patientid', '=', $patientId)
																						  	  ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $ledger;
	}

	public function getPendingClaims($where)
	{
		$pendingClaims = Ledger::join('dental_transaction_code', 'dental_transaction_code.transaction_code', '=', 'dental_ledger.transaction_code')
						->join('dental_users', 'dental_users.userid', '=', 'dental_ledger.docid')
						->join('dental_patients', 'dental_patients.patientid', '=', 'dental_ledger.patientid');

		foreach ($where as $key => $value) {
			$pendingClaims = $pendingClaims->where($key, '=', $value);
		}

		$pendingClaims = $pendingClaims->distinct()
									   ->get();

		return $pendingClaims;
	}

	public function getNumRecords($primaryClaimId, $ledgerIds)
	{
		$numRecords = Ledger::select(DB::raw('COUNT(*) as num_ledger'))
					->where('primary_claim_id', '=', $primaryClaimId)
					->whereRaw('ledgerid NOT IN (' . $ledgerIds . ')')
					->first();

		return $numRecords;
	}

	public function insertData($data)
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

	public function updateData($where, $values)
	{
		$ledger = new Ledger();

		foreach ($where as $attribute => $value) {
			$ledger = $ledger->where($attribute, '=', $value);
		}

		$ledger = $ledger->update($values);

		return $ledger;
	}

	public function updatePrimaryClaimId($id, $ledgerIds, $primaryClaimId)
	{
		$ledger = Ledger::where('primary_claim_id', '=', $id)
				->whereRaw('ledgerid NOT IN (' . $ledgerIds . ')')
				->update(array(
					'primary_claim_id' => $primaryClaimId
				));

		return $ledger;
	}

	public function deleteData($where)
	{
		$ledger = new Ledger();

		foreach ($where as $attribute => $value) {
			$ledger = $ledger->where($attribute, '=', $value);
		}

		$ledger = $ledger->delete();

		return $ledger;
	}
}