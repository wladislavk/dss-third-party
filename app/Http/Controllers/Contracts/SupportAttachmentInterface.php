<?php
namespace Ds3\Contracts;

interface SupportAttachmentInterface
{
    public function getAttachmentsById($id);
    public function insertData($data);
}
