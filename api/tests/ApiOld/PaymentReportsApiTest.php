<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\PaymentReport;
use Tests\TestCases\ApiTestCase;

class PaymentReportsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PaymentReport::class;
    }

    protected function getRoute()
    {
        return '/payment-reports';
    }

    protected function getStoreData()
    {
        return [
            "claimid" => 100,
            "reference_id" => "AE234N31351XAHH",
            "viewed" => 1,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'claimid'      => 54,
            'reference_id' => 'ABC123DEF456',
            'viewed'       => 1,
        ];
    }
}
