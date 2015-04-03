<?php
namespace Ds3\Contracts;

interface SupportTicketInterface
{
    public function getSupport($docId, $status);
    public function getOpenTickets($docId, $status);
    public function getClosedTickets($docId, $status);
    public function insertData($data);
    public function updateData($id, $values);
}
