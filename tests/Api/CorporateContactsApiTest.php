<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\CorporateContact;
use Tests\TestCases\ApiTestCase;

class CorporateContactsApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/corporate-contacts -> CorporateContactsController@store method
     */
    public function testAddCorporateContact()
    {
        $data = factory(CorporateContact::class)->make()->toArray();

        $data['docid'] = 123;

        $this->post('/api/v1/corporate-contacts', $data)
            ->seeInDatabase('dental_fcontact', ['docid' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/corporate-contacts/{id} -> CorporateContactsController@update method
     */
    public function testUpdateCorporateContact()
    {
        $corporateContactTestRecord = factory(CorporateContact::class)->create();

        $data = [
            'docid'     => 123,
            'firstname' => 'John',
            'lastname'  => 'Doe',
        ];

        $this->put('/api/v1/corporate-contacts/' . $corporateContactTestRecord->contactid, $data);
        $this
            ->seeInDatabase('dental_fcontact', ['docid' => 123])
            ->assertResponseOk()
        ;
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/corporate-contacts/{id} -> CorporateContactsController@destroy method
     */
    public function testDeleteCorporateContact()
    {
        $corporateContactTestRecord = factory(CorporateContact::class)->create();

        $this->delete('/api/v1/corporate-contacts/' . $corporateContactTestRecord->contactid);
        $this
            ->notSeeInDatabase('dental_fcontact', [
                'contactid' => $corporateContactTestRecord->contactid,
            ])
            ->assertResponseOk()
        ;
    }
}
