<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\PatientInsurance;
use Tests\TestCases\ApiTestCase;

class PatientInsurancesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return PatientInsurance::class;
    }

    protected function getRoute()
    {
        return '/patient-insurances';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 100,
            "insurancetype" => 6,
            "company" => "Modi doloribus illo alias.",
            "address1" => "9247 Kris Loaf\nSouth Gabriellebury, SC 02276",
            "address2" => "892 Marie Glens\nNorth Rhiannon, MS 40966-6218",
            "city" => "West Branson",
            "state" => "AZ",
            "zip" => "41427",
            "phone" => "8859285131",
            "fax" => "(203) 557-0545",
            "email" => "jasmin.mcdermott@hotmail.com",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid' => 85,
            'company'   => 'test company',
            'zip'       => 12345,
            'email'     => 'test@mail.com',
        ];
    }
}
