<?php
namespace Ds3\Repositories;

use Ds3\Contracts\SupportAttachmentInterface;
use Ds3\Eloquent\Support\SupportAttachment;

class SupportAttachmentRepository implements SupportAttachmentInterface
{
    public function insertData($data)
    {
        $supportAttachment = new SupportAttachment();

        foreach ($data as $attribute => $value) {
            $supportAttachment->$attribute = $value;
        }

        $supportAttachment->save();

        return $supportAttachment->id;
    }
}
