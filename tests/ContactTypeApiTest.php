<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ContactTypeApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $contacttypeid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/contact-type -> Api/ApiContactTypeController@store method
     * 
     */
    public function testAddContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'contacttype' => 'test_contacttype_added',
            'description' => 'test_description_added',
            'sortby'      => 77,
            'status'      => 1,
            'physician'   => 2,
            'corporate'   => 3
        ];

        $this->post('/api/v1/contact-type', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contacttype', ['status' => 1]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/contact-type/{contacttypeid} -> Api/ApiContactTypeController@update method
     * 
     */
    public function testUpdateContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTypeTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ContactType::class)->create();

        $data = [
            'sortby'      => 78,
            'contacttype' => 'update_test_contacttype_added'
        ];

        $this->put('/api/v1/contact-type/' . $contactTypeTestRecord->contacttypeid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_contacttype', ['contacttype' => 'update_test_contacttype_added']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/contact-type/{contacttypeid} -> Api/ApiContactTypeController@destroy method
     * 
     */
    public function testDeleteContactType()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $contactTypeTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ContactType::class)->create();

        $this->delete('/api/v1/contact-type/' . $contactTypeTestRecord->contacttypeid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_contacttype', ['contacttypeid' => $contactTypeTestRecord->contacttypeid]);
    }
}
