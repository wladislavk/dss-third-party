<?php namespace Ds3\Contracts;

interface SupportTicketInterface
{
    public function getSupport($docId, $status);
    public function insertData($data);
}
