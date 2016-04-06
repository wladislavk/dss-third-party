<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\TeethExam;

class TeethExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/teeth-exams -> TeethExamsController@store method
     * 
     */
    public function testAddTeethExam()
    {
        $data = factory(TeethExam::class)->make()->toArray();

        $data['status'] = 5;

        $this->post('/api/v1/teeth-exams', $data)
            ->seeInDatabase('dental_exam_teeth', ['status' => 5])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/teeth-exams/{id} -> TeethExamsController@update method
     * 
     */
    public function testUpdateTeethExam()
    {
        $teethExamTestRecord = factory(TeethExam::class)->create();

        $data = [
            'description' => 'updated description',
            'status'      => 7
        ];

        $this->put('/api/v1/teeth-exams/' . $teethExamTestRecord->exam_teethid, $data)
            ->seeInDatabase('dental_exam_teeth', [
                'description' => 'updated description'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/teeth-exams/{id} -> TeethExamsController@destroy method
     * 
     */
    public function testDeleteTeethExam()
    {
        $teethExamTestRecord = factory(TeethExam::class)->create();

        $this->delete('/api/v1/teeth-exams/' . $teethExamTestRecord->exam_teethid)
            ->notSeeInDatabase('dental_exam_teeth', [
                'exam_teethid' => $teethExamTestRecord->exam_teethid
            ])
            ->assertResponseOk();
    }
}
