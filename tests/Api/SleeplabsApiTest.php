<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Sleeplab;
use Tests\TestCases\ApiTestCase;

class SleeplabsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Sleeplab::class;
    }

    protected function getRoute()
    {
        return '/sleeplabs';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 100,
            "salutation" => "quod",
            "lastname" => "Hauck",
            "firstname" => "Arnulfo",
            "middlename" => "A",
            "company" => "Grimes, McKenzie and Goodwin",
            "add1" => "2760 Sarai Rapid Apt. 169\nEast Demetriusborough, AL 39796",
            "add2" => "17592 Witting Row\nPort Kristinville, OH 59307-3402",
            "city" => "West Augustinetown",
            "state" => "MO",
            "zip" => "18796",
            "phone1" => "8872933703",
            "phone2" => "9584943125",
            "fax" => "2271415283",
            "email" => "rzieme@yahoo.com",
            "greeting" => "et",
            "sincerely" => "dolorum",
            "notes" => "Iste adipisci aspernatur ut cum adipisci ut.",
            "status" => 4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'email'     => 'test@email.com',
            'lastname'  => 'Doe',
            'firstname' => 'John',
        ];
    }
}
