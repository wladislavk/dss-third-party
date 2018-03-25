<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SupportTicketInterface;
use Ds3\Eloquent\Support\SupportTicket;

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

    public function getOpenTickets($docId, $status)
    {
        $openTickets = DB::table(DB::raw('dental_support_tickets t'))
            ->select(DB::raw('t.*, '
                . '(SELECT name FROM companies WHERE companies.id = t.company_id LIMIT 1) as company_name, '
                . '(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id = t.id AND r.response_type = 0 ORDER BY r.viewed ASC LIMIT 1) AS response_viewed, '
                . '(SELECT r2.attachment FROM dental_support_responses r2 WHERE r2.ticket_id = t.id ORDER BY r2.attachment DESC LIMIT 1) AS response_attachment, '
                . '(SELECT a.filename FROM dental_support_attachment a WHERE a.ticket_id = t.id LIMIT 1) as ticket_attachment, '
                . 'response.last_response'))
            ->leftJoin(DB::raw('(SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id) response'), 'response.ticket_id', '=', 't.id')
            ->where('t.docid', '=', $docId)
            ->where(function($query) use ($status)
            {
                $query->whereIn('t.status', array($status['DSS_TICKET_STATUS_OPEN'], $status['DSS_TICKET_STATUS_REOPENED']))
                    ->orWhere(function($query) use ($status)
                    {
                        $query->where('t.status', '=', $status['DSS_TICKET_STATUS_CLOSED'])
                            ->whereRaw('(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id = t.id AND r.response_type = 0 ORDER BY r.viewed ASC LIMIT 1) = 0')
                            ->orWhere(function($query)
                            {
                                $query->where('t.create_type', '=', 0)
                                    ->where('t.viewed', '=', 0);
                            });
                    });
            })
            ->orderBy('t.adddate', 'desc')
            ->get();

        return $openTickets;
    }

    public function getClosedTickets($docId, $status)
    {
        $closedTickets = DB::table(DB::raw('dental_support_tickets t'))
            ->select(DB::raw('t.*, (SELECT name FROM companies WHERE companies.id=t.company_id LIMIT 1) as company_name'))
            ->leftJoin(DB::raw('(SELECT MAX(r2.adddate) as last_response, r2.ticket_id FROM dental_support_responses r2 GROUP BY r2.ticket_id ) response'), 'response.ticket_id', '=', 't.id')
            ->where('t.docid', '=', $docId)
            ->where('t.status', '=', $status)
            ->where(function($query)
            {
                $query->whereRaw('(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id = t.id AND r.response_type = 0 ORDER BY r.viewed ASC LIMIT 1) = 1')
                    ->orWhereRaw('(SELECT r.viewed FROM dental_support_responses r WHERE r.ticket_id = t.id AND r.response_type = 0 ORDER BY r.viewed ASC LIMIT 1) IS NULL');
            })
            ->orderBy('t.adddate', 'desc')
            ->get();

        return $closedTickets;
    }

    public function getTicketById($id)
    {
        $supportTicket = DB::table(DB::raw('dental_support_tickets t'))
            ->select('t.*', DB::raw('(SELECT name FROM companies WHERE companies.id=t.company_id LIMIT 1) AS company_name'))
            ->where('t.id', '=', $id)
            ->first();

        return $supportTicket;
    }

    public function insertData($data)
    {
        $supportTicket = new SupportTicket();

        foreach ($data as $attribute => $value) {
            $supportTicket->$attribute = $value;
        }

        $supportTicket->save();

        return $supportTicket->id;
    }

    public function updateData($id, $values, $created = false)
    {
        $supportTicket = SupportTicket::where('id', '=', $id);

        if (!$created) {
            $supportTicket = $supportTicket->nonCreated();
        }

        $supportTicket = $supportTicket->update($values);

        return $supportTicket;
    }
}
