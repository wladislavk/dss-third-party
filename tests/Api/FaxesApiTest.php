<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Fax;
use Tests\TestCases\ApiTestCase;

class FaxesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Fax::class;
    }

    protected function getRoute()
    {
        return '/faxes';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 10,
            "userid" => 8,
            "docid" => 3,
            "pages" => 7,
            "contactid" => 1,
            "to_number" => "6380246714",
            "to_name" => "Andreanne Zboncak",
            "letterid" => 5,
            "filename" => "f6_p35_u5_2017-07-20_05-12-15.pdf",
            "status" => 6,
            "adddate" => "2017-07-20 05:12:15",
            "fax_invoice_id" => 5,
            "sfax_transmission_id" => "9277320612255801160",
            "sfax_completed" => 0,
            "sfax_status" => 9,
            "viewed" => 1,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'userid' => 100,
        ];
    }
}
