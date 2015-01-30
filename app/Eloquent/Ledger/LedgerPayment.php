<?php namespace Ds3\Eloquent\Ledger;

use Illuminate\Database\Eloquent\Model;

class LedgerPayment extends Model
{
	protected $table = 'dental_ledger_payment';

	protected $fillable = ['payer', 'amount', 'payment_type', 'ledgerid'];

	protected $primaryKey = 'id';

	public static function get($ledgerId)
	{
		$ledgerPayment = LedgerPayment::where('ledgerid', '=', $ledgerId)->get();

		return $ledgerPayment;
	}

	public static function getPayments($primaryClaimId)
	{
		$payments = DB::table(DB::raw('dental_ledger_payment dlp'))->join(DB::raw('dental_ledger dl'), 'dlp.ledgerid', '=', 'dl.ledgerid')
																   ->where('dl.primary_claim_id', '=', $primaryClaimId)
																   ->get();

		return $payments;
	}
}