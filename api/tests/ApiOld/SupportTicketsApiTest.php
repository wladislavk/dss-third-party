<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportTicket;
use Tests\TestCases\ApiTestCase;

class SupportTicketsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return SupportTicket::class;
    }

    protected function getRoute()
    {
        return '/support-tickets';
    }

    protected function getStoreData()
    {
        return [
            "title" => "Sed odit est dolorum praesentium.",
            "userid" => 100,
            "docid" => 3,
            "body" => "Sint cumque impedit accusantium ullam in.",
            "category_id" => 5,
            "status" => 7,
            "attachment" => "9ki2mxg9sl4u3_b6q.jpg",
            "viewed" => 0,
            "creator_id" => 3,
            "create_type" => 7,
            "company_id" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid' => 100,
            'body'  => 'updated support ticket',
        ];
    }
}
