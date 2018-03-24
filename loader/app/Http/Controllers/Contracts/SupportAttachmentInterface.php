<?php
namespace Ds3\Contracts;

interface SupportAttachmentInterface
{
    public function getAttachmentsById($id, $response = false);
    public function insertData($data);
}
