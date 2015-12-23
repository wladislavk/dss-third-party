<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ContactApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $contactid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/contact -> Api/ApiContactController@store method
     * 
     */
    public function testAddContact()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'docid'         => 5,
            'lastname'      => 'John',
            'firstname'     => 'Doe',
            'company'       => 'Test company',
            'add1'          => 'add1',
            'city'          => 'city',
            'state'         => 'state',
            'zip'           => '12345',
            'phone1'        => '1234567890',
            'email'         => 'test@email.com',
            'contacttypeid' => 5
        ];

        $this->post('/api/v1/contact', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contact', ['company' => 'Test company']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/contact/{id} -> Api/ApiContactController@update method
     * 
     */
    public function testUpdateContact()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTestRecord = factory(DentalSleepSolutions\Models\Contact::class)->create();

        $data = [
            'docid'         => 5,
            'lastname'      => 'John',
            'firstname'     => 'Doe',
            'company'       => 'Updated test company'
        ];

        $this->put('/api/v1/contact/' . $contactTestRecord->contactid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contact', ['company' => 'Updated test company']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/contact/{id} -> Api/ApiContactController@destroy method
     * 
     */
    public function testDeleteContact()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTestRecord = factory(DentalSleepSolutions\Models\Contact::class)->create();

        $this->delete('/api/v1/contact/' . $contactTestRecord->contactid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_contact', ['contactid' => $contactTestRecord->contactid]);
    }
}
