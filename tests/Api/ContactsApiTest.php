<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Models\Dental\Contact;

class ContactsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Contact::class;
    }

    protected function getRoute()
    {
        return '/contacts';
    }

    protected function getStoreData()
    {
        return [
            'docid'         => 0,
            'lastname'      => 'John',
            'firstname'     => 'Doe',
            'company'       => 'Test company',
            'add1'          => 'add1',
            'city'          => 'city',
            'state'         => 'state',
            'zip'           => '12345',
            'phone1'        => '1234567890',
            'email'         => 'test@email.com',
            'contacttypeid' => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'docid'         => 5,
            'lastname'      => 'John',
            'firstname'     => 'Doe',
            'company'       => 'Updated test company',
        ];
    }
}
