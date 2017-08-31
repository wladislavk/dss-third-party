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

    public function testFind()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/find');
        $this->assertResponseOk();
        $expected = [
            'totalCount' => 0,
            'result' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetListContactsAndCompanies()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/list-contacts-and-companies');
        $this->assertResponseOk();
        $expected = [
            'error' => 'Error: No match found for this criteria.',
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetWithContactType()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/with-contact-type');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }

    public function testGetInsuranceContacts()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/insurance');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetReferredByContacts()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/referred-by');
        $this->assertResponseOk();
        $expected = [
            'total' => 0,
            'contacts' => [],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }

    public function testGetCorporateContacts()
    {
        $this->post(self::ROUTE_PREFIX . '/contacts/corporate');
        $this->assertResponseOk();
        $expected = [
            'total' => 1,
            'result' => [
                [
                    'contactid' => 146,
                    'docid' => 1,
                    'salutation' => '',
                    'lastname' => 'corporate',
                    'firstname' => 'test corp',
                    'middlename' => '',
                    'company' => 'corporate contact1',
                    'add1' => '123 test',
                    'add2' => '',
                    'city' => 'city',
                    'state' => 'state',
                    'zip' => '12345',
                    'phone1' => '5555555555',
                    'phone2' => '5555555555',
                    'fax' => '890898908',
                    'email' => '',
                    'national_provider_id' => '',
                    'qualifier' => '0',
                    'qualifierid' => '',
                    'greeting' => '',
                    'sincerely' => '',
                    'contacttypeid' => 25,
                    'notes' => '',
                    'preferredcontact' => '',
                    'status' => 1,
                    'adddate' => '2014-03-18 23:08:35',
                    'ip_address' => '68.253.133.237',
                    'referredby_info' => null,
                    'old_referredbyid' => null,
                    'referredby_notes' => null,
                    'merge_id' => null,
                    'merge_date' => null,
                    'corporate' => 1,
                    'dea_number' => null,
                    'contacttype' => 'test corporate type',
                ],
            ],
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
