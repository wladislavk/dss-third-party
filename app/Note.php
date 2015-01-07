<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Note extends Model
{
	protected $table = 'dental_patients';

	protected $fillable = ['patientid', 'notes'];

	protected $primaryKey = 'notesid';

	public static function getUnsigned($docId)
	{
		$unsigned = DB::table(DB::raw('(SELECT n.*, u.name signed_name, p.adddate AS parent_adddate FROM (SELECT * FROM dental_notes WHERE status != 0 AND docid = ' . $docId . ' ORDER BY adddate DESC) AS n
										LEFT JOIN dental_users u ON u.userid = n.signed_id
										LEFT JOIN dental_notes p ON p.notesid = n.parentid
										GROUP BY n.parentid
										ORDER BY n.procedure_date DESC, n.adddate DESC) AS m'))->whereNull('m.signed_on')
																							   ->orWhere('m.signed_on', '=', '')
																							   ->get();

		return $unsigned;
	}
}