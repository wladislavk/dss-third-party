<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\InsuranceType;
use Tests\TestCases\ApiTestCase;

class InsuranceTypesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceType::class;
    }

    protected function getRoute()
    {
        return '/insurance-types';
    }

    protected function getStoreData()
    {
        return [
            "ins_type" => "Voluptatem qui non numquam.",
            "description" => "Ipsum temporibus enim accusantium laboriosam eos qui doloremque.",
            "sortby" => 100,
            "status" => 5,
            "adddate" => "1984-06-29 01:26:27",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated insurance type',
            'status'      => 3,
        ];
    }
}
