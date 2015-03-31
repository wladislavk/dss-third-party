<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SupportTicketInterface;
use Ds3\Eloquent\SupportTicket;

class SupportTicketRepository implements SupportTicketInterface
{
    public function getSupport($docId, $status)
    {
        $support = DB::table(DB::raw('dental_support_tickets t'))
            ->leftJoin(DB::raw('dental_support_responses r'), 'r.ticket_id', '=', 't.id')
            ->where('t.docid', '=', $docId)
            ->whereRaw("((r.viewed = 0 AND r.response_type = 0) OR (t.viewed = 0 AND t.create_type = 0) OR (t.status = " . $status . " AND r.viewed = 0 AND r.response_type = 0 AND r.body != ''))")
            ->groupBy('t.id')
            ->get();

        return $support;
    }

    public function insertData($data)
    {
        $supportTicket = new SupportTicket();

        foreach ($data as $attribute => $value) {
            $supportTicket->$attribute = $value;
        }

        try {
            $supportTicket->save();
        } catch (QueryException $e) {
            return null;
        }

        return $supportTicket->id;
    }
}
