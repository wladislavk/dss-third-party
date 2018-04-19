<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimText;
use Tests\TestCases\ApiTestCase;

class ClaimTextsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ClaimText::class;
    }

    protected function getRoute()
    {
        return '/claim-texts';
    }

    protected function getStoreData()
    {
        return [
            'title'        => 'test',
            'description'  => 'test description',
            'default_text' => 1,
            'companyid'    => 1,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test description',
        ];
    }
}
