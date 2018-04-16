<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\MedicalHistory;
use Tests\TestCases\ApiTestCase;

class MedicalHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return MedicalHistory::class;
    }

    protected function getRoute()
    {
        return '/medical-histories';
    }

    protected function getStoreData()
    {
        return [
            "history" => "repudiandae",
            "description" => "Nulla modi vel qui voluptatem.",
            "sortby" => 9,
            "status" => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated medical history',
            'sortby'      => 100,
        ];
    }
}
