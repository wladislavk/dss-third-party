<?php
namespace Ds3\Contracts;

interface SupportResponseInterface
{
    public function getResponsesById($id);
    public function insertData($data);
    public function updateData($ticketId, $values);
}
