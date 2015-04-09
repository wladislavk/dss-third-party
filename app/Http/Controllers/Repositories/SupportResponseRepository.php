<?php
namespace Ds3\Repositories;

use Ds3\Contracts\SupportResponseInterface;
use Ds3\Eloquent\Support\SupportResponse;

class SupportResponseRepository implements SupportResponseInterface
{
    public function getResponsesById($id)
    {
        $responses = new SupportResponse();

        foreach ($id as $attribute => $value) {
            $responses = $responses->where($attribute, '=', $value);
        }

        return $responses->get();
    }

    public function insertData($data)
    {
        $response = new SupportResponse();

        foreach ($data as $attribute => $value) {
            $response->$attribute = $value;
        }

        $response->save();

        return $response->id;
    }

    public function updateData($ticketId, $values)
    {
        $supportTicket = SupportResponse::where('ticket_id', '=', $ticketId)
            ->noResponse()
            ->update($values);

        return $supportTicket;
    }
}
