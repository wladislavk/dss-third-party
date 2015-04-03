<?php
namespace Ds3\Repositories;

use Ds3\Contracts\SupportResponseInterface;
use Ds3\Eloquent\Support\SupportResponse;

class SupportResponseRepository implements SupportResponseInterface
{
    public function updateData($ticketId, $values)
    {
        $supportTicket = SupportResponse::where('ticket_id', '=', $ticketId)
            ->noResponse()
            ->update($values);

        return $supportTicket;
    }
}
