<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ComplaintApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $complaintid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/complaint -> Api/ApiComplaintController@store method
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

        $this->post('/api/v1/complaint', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_complaint', ['complaint' => 'Test complaint']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/complaint/{id} -> Api/ApiComplaintController@update method
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

        $this->put('/api/v1/complaint/' . $complaintTestRecord->complaintid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_complaint', ['complaint' => 'Updated test complaint']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/complaint/{id} -> Api/ApiComplaintController@destroy method
     * 
     */
    public function testDeleteComplaint()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $complaintTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Complaint::class)->create();

        $this->delete('/api/v1/complaint/' . $complaintTestRecord->complaintid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_complaint', ['complaintid' => $complaintTestRecord->complaintid]);
    }
}
