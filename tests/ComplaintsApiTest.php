<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ComplaintsApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/complaints -> Api/ApiComplaintsController@store method
     * 
     */
    public function testAddComplaint()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'complaint' => 'Test complaint',
            'sortby'    => 5,
            'status'    => 5
        ];

        $this->post('/api/v1/complaints', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_complaint', ['complaint' => 'Test complaint']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/complaints/{id} -> Api/ApiComplaintsController@update method
     * 
     */
    public function testUpdateComplaint()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $complaintTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Complaint::class)->create();

        $data = [
            'complaint' => 'Updated test complaint',
            'status'    => 0
        ];

        $this->put('/api/v1/complaints/' . $complaintTestRecord->complaintid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_complaint', ['complaint' => 'Updated test complaint']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/complaints/{id} -> Api/ApiComplaintsController@destroy method
     * 
     */
    public function testDeleteComplaint()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $complaintTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Complaint::class)->create();

        $this->delete('/api/v1/complaints/' . $complaintTestRecord->complaintid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_complaint', ['complaintid' => $complaintTestRecord->complaintid]);
    }
}
