<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class LedgerRec extends Model
{
	protected $table = 'dental_ledger_rec';

	protected $fillable = ['formid', 'patientid', 'description'];

	protected $primaryKey = 'ledgerid';

	public static function insertData($data)
	{
		$ledgerRec = new LedgerRec();

		foreach ($data as $attribute => $value) {
			$ledgerRec->$attribute = $value;
		}

		try {
			$ledgerRec->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $ledgerRec->ledgerid;
	}
}