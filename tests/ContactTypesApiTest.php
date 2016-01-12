<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ContactTypesApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/contact-types -> Api/ApiContactTypesController@store method
     * 
     */
    public function testAddContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'contacttype' => 'test',
            'description' => 'test description',
            'sortby'      => 10,
            'status'      => 10,
            'physician'   => 0,
            'corporate'   => 0
        ];

        $this->post('/api/v1/contact-types', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contacttype', ['status' => 10]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/contact-types/{contacttypeid} -> Api/ApiContactTypesController@update method
     * 
     */
    public function testUpdateContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTypeTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ContactType::class)->create();

        $data = [
            'sortby'      => 10,
            'contacttype' => 'updated contact type'
        ];

        $this->put('/api/v1/contact-types/' . $contactTypeTestRecord->contacttypeid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contacttype', ['contacttype' => 'updated contact type']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/contact-types/{contacttypeid} -> Api/ApiContactTypesController@destroy method
     * 
     */
    public function testDeleteContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTypeTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ContactType::class)->create();

        $this->delete('/api/v1/contact-types/' . $contactTypeTestRecord->contacttypeid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_contacttype', ['contacttypeid' => $contactTypeTestRecord->contacttypeid]);
    }
}
