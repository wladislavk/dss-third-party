<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class SupportTicket extends Model
{
	protected $table = 'dental_support_tickets';

	protected $fillable = ['title', 'userid', 'docid', 'body', 'category_id'];

	protected $primaryKey = 'id';

	public static function getSupport($docId, $DSS_TICKET_STATUS_CLOSED)
	{
		$support = DB::table(DB::raw('dental_support_tickets t'))->leftJoin(DB::raw('dental_support_responses r'), 'r.ticket_id', '=', 't.id')
																 ->where('t.docid', '=', $docId)
																 ->where(DB::raw("((r.viewed = 0 AND r.response_type = 0) OR (t.viewed = 0 AND t.create_type = 0) OR (t.status = " . $DSS_TICKET_STATUS_CLOSED . " AND r.viewed = 0 AND r.response_type = 0 AND r.body != ''))"))
																 ->groupBy('t.id')
																 ->get();

		return $support;
	}
}