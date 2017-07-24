<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\CorporateContact;
use Tests\TestCases\ApiTestCase;

class CorporateContactsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return CorporateContact::class;
    }

    protected function getRoute()
    {
        return '/corporate-contacts';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 123,
            "salutation" => "Mr.",
            "lastname" => "Abbott",
            "firstname" => "Raymond",
            "middlename" => "error",
            "company" => "Cassin-Hudson",
            "add1" => "330 Lenna Field\nNew Jessica, MN 21169",
            "add2" => "6057 Lloyd Ramp Suite 220\nLinaborough, SD 36147-6282",
            "city" => "Cassidychester",
            "state" => "Idaho",
            "zip" => "16610",
            "phone1" => "1170354831",
            "phone2" => "1141421399",
            "fax" => "1984691824",
            "email" => "nathan24@bradtke.biz",
            "greeting" => "Mrs.",
            "sincerely" => "Mr.",
            "contacttypeid" => 7,
            "notes" => "Voluptatem dicta alias ut incidunt error.",
            "adddate" => "2000-01-08 07:59:13",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid'     => 123,
            'firstname' => 'John',
            'lastname'  => 'Doe',
        ];
    }
}
