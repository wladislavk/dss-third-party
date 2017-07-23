<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\ReferredByContact;
use Tests\TestCases\ApiTestCase;

class ReferredByContactsApiTest extends ApiTestCase
{
    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/referred-by-contacts -> ReferredByContactsController@store method
     * 
     */
    public function testAddReferredByContact()
    {
        $data = factory(ReferredByContact::class)->make()->toArray();

        $data['docid'] = 1234;

        $this->json('POST', '/api/v1/referred-by-contacts', $data);
        $this
            ->seeInDatabase('dental_referredby', ['docid' => 1234])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/referred-by-contacts/{id} -> ReferredByContactsController@update method
     * 
     */
    public function testUpdateReferredByContact()
    {
        $referredByContactTestRecord = factory(ReferredByContact::class)->create();

        $data = [
            'company' => 'US Test Company',
            'add1'    => 'Fake Street, 16'
        ];

        $this->put('/api/v1/referred-by-contacts/' . $referredByContactTestRecord->referredbyid, $data)
            ->seeInDatabase('dental_referredby', ['company' => 'US Test Company'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/referred-by-contacts/{id} -> ReferredByContactsController@destroy method
     * 
     */
    public function testDeleteReferredByContact()
    {
        $referredByContactTestRecord = factory(ReferredByContact::class)->create();

        $this->delete('/api/v1/referred-by-contacts/' . $referredByContactTestRecord->referredbyid)
            ->notSeeInDatabase('dental_referredby', [
                'referredbyid' => $referredByContactTestRecord->referredbyid
            ])
            ->assertResponseOk();
    }
}
