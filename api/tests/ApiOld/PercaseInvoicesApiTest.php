<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\PercaseInvoice;
use Tests\TestCases\ApiTestCase;

class PercaseInvoicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PercaseInvoice::class;
    }

    protected function getRoute()
    {
        return '/percase-invoices';
    }

    protected function getStoreData()
    {
        return [
            "adminid" => 100,
            "docid" => 6,
            "status" => 0,
            "companyid" => 9,
            "user_fee_desc" => "hic",
            "producer_fee_desc" => "omnis",
            "invoice_type" => 3,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid'         => 100,
            'user_fee_desc' => 'updated percase invoice',
        ];
    }
}
