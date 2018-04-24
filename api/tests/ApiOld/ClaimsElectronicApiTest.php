<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimElectronic;
use Carbon\Carbon;
use Tests\TestCases\ApiTestCase;

class ClaimsElectronicApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ClaimElectronic::class;
    }

    protected function getRoute()
    {
        return '/claims-electronic';
    }

    protected function getStoreData()
    {
        return [
            'claimid'         => 10,
            'response'        => '{"success":true}',
            'reference_id'    => 'testId',
            'percase_date'    => Carbon::now(),
            'percase_name'    => 'test name',
            'percase_amount'  => 123.45,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'claimid'      => 10,
            'percase_name' => 'updated percase name',
        ];
    }
}
