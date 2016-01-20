<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Assessment;

class AssessmentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/assessments -> AssessmentsController@store method
     * 
     */
    public function testAddAssessment()
    {
        $data = [
            'assessment'  => 'testAssessment',
            'description' => 'testDescription',
            'sortby'      => 10,
            'status'      => 2
        ];

        $this->post('/api/v1/assessments', $data)
            ->seeInDatabase('dental_assessment', ['assessment' => 'testAssessment'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/assessments/{id} -> AssessmentsController@update method
     * 
     */
    public function testUpdateAssessment()
    {
        $assessmentTestRecord = factory(Assessment::class)->create();

        $data = [
            'assessment' => 'testUpdatedAssessment',
            'status'     => 5
        ];

        $this->put('/api/v1/assessments/' . $assessmentTestRecord->assessmentid, $data)
            ->seeInDatabase('dental_assessment', ['assessment' => 'testUpdatedAssessment'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/assessments/{id} -> AssessmentsController@destroy method
     * 
     */
    public function testDeleteAssessment()
    {
        $assessmentTestRecord = factory(Assessment::class)->create();

        $this->delete('/api/v1/assessments/' . $assessmentTestRecord->assessmentid)
            ->notSeeInDatabase('dental_assessment', ['assessmentid' => $assessmentTestRecord->assessmentid])
            ->assertResponseOk();
    }
}
