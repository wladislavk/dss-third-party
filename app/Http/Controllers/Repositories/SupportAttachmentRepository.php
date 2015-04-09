<?php
namespace Ds3\Repositories;

use Ds3\Contracts\SupportAttachmentInterface;
use Ds3\Eloquent\Support\SupportAttachment;

class SupportAttachmentRepository implements SupportAttachmentInterface
{
    public function getAttachmentsById($id)
    {
        $supportAttachments = SupportAttachment::whereNull('response_id');

        foreach ($id as $attribute => $value) {
            $supportAttachments = $supportAttachments->where($attribute, '=', $value);
        }

        return $supportAttachments->get();
    }

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
