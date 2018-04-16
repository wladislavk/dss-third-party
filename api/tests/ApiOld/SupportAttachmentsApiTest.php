<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportAttachment;
use Tests\TestCases\ApiTestCase;

class SupportAttachmentsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SupportAttachment::class;
    }

    protected function getRoute()
    {
        return '/support-attachments';
    }

    protected function getStoreData()
    {
        return [
            "ticket_id" => 100,
            "response_id" => 5,
            "filename" => "support_attachment_3_8_1148.jpg",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'response_id' => 132,
        ];
    }
}
