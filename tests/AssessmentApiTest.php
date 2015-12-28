<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AssessmentApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $assessmentid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/assessment -> Api/ApiAssessmentController@store method
     * 
     */
    public function testAddAssessment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'assessment'  => 'testAssessment',
            'description' => 'testDescription',
            'sortby'      => 10,
            'status'      => 2
        ];

        $this->post('/api/v1/assessment', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_assessment', ['assessment' => 'testAssessment']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/assessment/{id} -> Api/ApiAssessmentController@update method
     * 
     */
    public function testUpdateAssessment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $assessmentTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Assessment::class)->create();

        $data = [
            'assessment' => 'testUpdatedAssessment',
            'status'     => 5
        ];

        $this->put('/api/v1/assessment/' . $assessmentTestRecord->assessmentid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_assessment', ['assessment' => 'testUpdatedAssessment']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/assessment/{id} -> Api/ApiAssessmentController@destroy method
     * 
     */
    public function testDeleteAssessment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $assessmentTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Assessment::class)->create();

        $this->delete('/api/v1/assessment/' . $assessmentTestRecord->assessmentid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_assessment', ['assessmentid' => $assessmentTestRecord->assessmentid]);
    }
}
