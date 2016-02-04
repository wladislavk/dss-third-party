<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam;

class TmjClinicalExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tmj-clinical-exams -> TmjClinicalExamsController@store method
     * 
     */
    public function testAddTmjClinicalExam()
    {
        $data = factory(TmjClinicalExam::class)->make()->toArray();

        $data['formid'] = 100;

        $this->post('/api/v1/tmj-clinical-exams', $data)
            ->seeInDatabase('dental_ex_page5', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tmj-clinical-exams/{id} -> TmjClinicalExamsController@update method
     * 
     */
    public function testUpdateTmjClinicalExam()
    {
        $tmjClinicalExamTestRecord = factory(TmjClinicalExam::class)->create();

        $data = [
            'patientid'          => 100,
            'other_range_motion' => 'test'
        ];

        $this->put('/api/v1/tmj-clinical-exams/' . $tmjClinicalExamTestRecord->ex_page5id, $data)
            ->seeInDatabase('dental_ex_page5', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tmj-clinical-exams/{id} -> TmjClinicalExamsController@destroy method
     * 
     */
    public function testDeleteTmjClinicalExam()
    {
        $tmjClinicalExamTestRecord = factory(TmjClinicalExam::class)->create();

        $this->delete('/api/v1/tmj-clinical-exams/' . $tmjClinicalExamTestRecord->ex_page5id)
            ->notSeeInDatabase('dental_ex_page5', ['ex_page5id' => $tmjClinicalExamTestRecord->ex_page5id])
            ->assertResponseOk();
    }
}
