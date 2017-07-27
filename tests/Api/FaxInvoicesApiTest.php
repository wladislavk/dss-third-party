<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\FaxInvoice;
use Tests\TestCases\ApiTestCase;

class FaxInvoicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return FaxInvoice::class;
    }

    protected function getRoute()
    {
        return '/fax-invoices';
    }

    protected function getStoreData()
    {
        return [
            'invoice_id' => 10,
            "description" => "Earum delectus dicta porro et debitis.",
            "start_date" => "2017-07-25",
            "end_date" => "2017-08-03",
            "amount" => "5.11",
            "adddate" => "2017-07-24 10:45:09",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'invoice_id' => 100,
            'amount'     => 5.55,
        ];
    }
}
