<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ExtraPercaseInvoice;
use Tests\TestCases\ApiTestCase;

class ExtraPercaseInvoicesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ExtraPercaseInvoice::class;
    }

    protected function getRoute()
    {
        return '/extra-percase-invoices';
    }

    protected function getStoreData()
    {
        return [
            "percase_name" => "Miss Michelle O'Kon DVM",
            "percase_date" => "2015-08-12",
            "percase_amount" => 20.43,
            "percase_status" => 9,
            "percase_invoice" => 100,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'percase_amount'  => 123.45,
            'percase_invoice' => 200,
        ];
    }
}
