<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceDiagnosis;
use Tests\TestCases\ApiTestCase;

class InsuranceDiagnosesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceDiagnosis::class;
    }

    protected function getRoute()
    {
        return '/insurance-diagnoses';
    }

    protected function getStoreData()
    {
        return [
            "ins_diagnosis" => "053.13 POSTHERPETIC POLYNEUROPATHY (6)",
            "description" => "Aspernatur dignissimos autem pariatur repudiandae molestias reiciendis.",
            "sortby" => 100,
            "status" => 3,
            "adddate" => "1995-11-26 05:42:06",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated insurance diagnosis',
            'status'      => 5,
        ];
    }
}
