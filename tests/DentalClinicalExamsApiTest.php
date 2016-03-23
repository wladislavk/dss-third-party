<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam;

class DentalClinicalExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/dental-clinical-exams -> DentalClinicalExamsController@store method
     * 
     */
    public function testAddDentalClinicalExam()
    {
        $data = factory(DentalClinicalExam::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/dental-clinical-exams', $data)
            ->seeInDatabase('dental_ex_page4', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/dental-clinical-exams/{id} -> DentalClinicalExamsController@update method
     * 
     */
    public function testUpdateDentalClinicalExam()
    {
        $dentalClinicalExamTestRecord = factory(DentalClinicalExam::class)->create();

        $data = [
            'patientid' => 55,
            'docid'     => 100
        ];

        $this->put('/api/v1/dental-clinical-exams/' . $dentalClinicalExamTestRecord->ex_page4id, $data)
            ->seeInDatabase('dental_ex_page4', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/dental-clinical-exams/{id} -> DentalClinicalExamsController@destroy method
     * 
     */
    public function testDeleteDentalClinicalExam()
    {
        $dentalClinicalExamTestRecord = factory(DentalClinicalExam::class)->create();

        $this->delete('/api/v1/dental-clinical-exams/' . $dentalClinicalExamTestRecord->ex_page4id)
            ->notSeeInDatabase('dental_ex_page4', [
                'ex_page4id' => $dentalClinicalExamTestRecord->ex_page4id
            ])
            ->assertResponseOk();
    }
}
