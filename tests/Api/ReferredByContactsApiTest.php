<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ReferredByContact;
use Tests\TestCases\ApiTestCase;

class ReferredByContactsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ReferredByContact::class;
    }

    protected function getRoute()
    {
        return '/referred-by-contacts';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 1234,
            "salutation" => "Dr.",
            "lastname" => "Hills",
            "firstname" => "Shad",
            "middlename" => "a",
            "company" => "Howell, Rowe and Erdman",
            "add1" => "5727 Klein Mill\nLake Corine, WI 46204-0362",
            "add2" => "608 Martina Ville Suite 536\nPierrehaven, OR 46670",
            "city" => "North Bonniemouth",
            "state" => "Arizona",
            "zip" => "71725",
            "phone1" => "1268955373",
            "phone2" => "1442633791",
            "fax" => "1064302272",
            "email" => "steuber.ila@gmail.com",
            "national_provider_id" => "426330678",
            "qualifier" => 8,
            "qualifierid" => "porro",
            "greeting" => "Mrs.",
            "sincerely" => "Dr.",
            "contacttypeid" => 1,
            "notes" => "A sapiente dolorum delectus dolores id deserunt.",
            "preferredcontact" => "ducimus",
            "status" => 4,
            "referredby_info" => 4,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'company' => 'US Test Company',
            'add1'    => 'Fake Street, 16',
        ];
    }
}
