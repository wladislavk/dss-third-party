<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\NasalPassage;
use Tests\TestCases\ApiTestCase;

class NasalPassagesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return NasalPassage::class;
    }

    protected function getRoute()
    {
        return '/nasal-passages';
    }

    protected function getStoreData()
    {
        return [
            "nasal_passages" => "Ipsam rerum possimus.",
            "description" => "Veritatis vero earum quo pariatur dolorem eos rem.",
            "sortby" => 8,
            "status" => 9,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated description',
            'status'      => 8,
        ];
    }
}
