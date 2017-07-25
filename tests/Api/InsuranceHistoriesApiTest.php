<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceHistory;
use Tests\TestCases\ApiTestCase;

class InsuranceHistoriesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceHistory::class;
    }

    protected function getRoute()
    {
        return '/insurance-histories';
    }

    protected function getStoreData()
    {
        return [
            "insuranceid" => 3,
            "formid" => 4,
            "patientid" => 6,
            "patient_firstname" => "Wyatt",
            "patient_lastname" => "Tremblay",
            "insured_firstname" => "Gerald",
            "insured_lastname" => "Jerde",
            "userid" => 100,
            "docid" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'        => 7,
            'patient_lastname' => 'test lastname',
        ];
    }
}
