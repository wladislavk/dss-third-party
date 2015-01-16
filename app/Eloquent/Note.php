<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class Note extends Model
{
	protected $table = 'dental_notes';

	protected $fillable = ['patientid', 'notes'];

	protected $primaryKey = 'notesid';

	public static function get($notesId)
	{
		try {
			$note = Note::where('notesid', '=', $notesId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $note;
	}

	public static function getJoinNote($notesId)
	{
		$note = DB::table(DB::raw('dental_notes n'))->select(DB::raw("n.*, CONCAT(u.first_name,' ',u.last_name) added_name"))
													->leftJoin(DB::raw('dental_users u'), 'u.userid', '=', 'n.userid')
													->where('notesid', '=', $notesId)
													->first();

		return $note;
	}

	public static function getJoinNotes($parentId, $notesId)
	{
		$notes = DB::table(DB::raw('dental_notes n'))->select(DB::raw('n.parentid, u.name'))
													 ->leftJoin(DB::raw('dental_users u'), 'n.userid', '=', 'u.userid')
													 ->where('parentid', '=', $parentId)
													 ->where('notesid', '!=', $notesId)
													 ->get();

		return $notes;
	}

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

	public static function insertData($data)
	{
		$note = new Note();

		foreach ($data as $attribute => $value) {
			$note->$attribute = $value;
		}

		try {
			$note->save();
		} catch (ModelNotFoundException $e) {
			return null;
		}

		return $note->notesid;
	}

	public static function updateData($notesId, $values)
	{
		$note = Note::where('notesid', '=', $notesId)->update($values);

		return $note;
	}
}