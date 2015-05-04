<?php
namespace Ds3\Contracts;

interface SupportTicketInterface
{
    public function getSupport($docId, $status);
    public function getOpenTickets($docId, $status);
    public function getClosedTickets($docId, $status);
    public function getTicketById($id);
    public function insertData($data);
    public function updateData($id, $values, $created = false);
}
