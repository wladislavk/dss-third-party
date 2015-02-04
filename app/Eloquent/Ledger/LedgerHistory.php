<?php namespace Ds3\Eloquent\Ledger;

use Illuminate\Database\Eloquent\Model;

class LedgerHistory extends Model
{
	protected $table = 'dental_ledger_history';

	protected $fillable = ['formid', 'patientid', 'description'];

	protected $primaryKey = 'ledgerid';

	public static function getJoin($ledgerId, $order = null)
	{
		$ledgerHistory = DB::table(DB::raw('dental_ledger_history h'))->select(DB::raw("h.updated_at, CONCAT(u.first_name,' ',u.last_name) doc_name, CONCAT(a.first_name,' ',a.last_name) admin_name"))
																	  ->leftJoin(DB::raw('dental_users u'), 'u.userid', '=', 'h.updated_by_user')
																	  ->leftJoin(DB::raw('admin a'), 'a.adminid', '=', 'h.updated_by_admin')
																	  ->where('h.ledgerid', '=', $ledgerId);

		if ($order == 'desc') {
			$ledgerHistory = $ledgerHistory->orderBy('h.updated_at', 'desc');
		} else {
			$ledgerHistory = $ledgerHistory->orderBy('h.updated_at');
		}

		return $ledgerHistory->first();
	}
}