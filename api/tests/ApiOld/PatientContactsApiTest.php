<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientContact;
use Tests\TestCases\ApiTestCase;

class PatientContactsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PatientContact::class;
    }

    protected function getRoute()
    {
        return '/patient-contacts';
    }

    protected function getStoreData()
    {
        return [
            "contacttype" => 2,
            "patientid" => 100,
            "firstname" => "Brandon",
            "lastname" => "Sporer",
            "address1" => "247 Bayer Mill Suite 813\nPort Aliyahville, NJ 42103",
            "address2" => "30798 Israel Ridge Apt. 589\nLake Hershel, NV 04820-8664",
            "city" => "Auerchester",
            "state" => "OK",
            "zip" => "33024",
            "phone" => "6615579647",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid' => 54,
            'firstname' => 'John',
            'lastname'  => 'Doe',
            'zip'       => 12345,
        ];
    }
}
