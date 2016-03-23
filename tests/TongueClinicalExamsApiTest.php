+<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam;

class TongueClinicalExamsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tongue-clinical-exams -> TongueClinicalExamsController@store method
     * 
     */
    public function testAddTongueClinicalExam()
    {
        $data = [
            'formid'               => 5,
            'patientid'            => 5,
            'blood_pressure'       => '130/85',
            'pulse'                => '5',
            'neck_measurement'     => 50.5,
            'bmi'                  => 12.5,
            'additional_paragraph' => 'paragraph',
            'tongue'               => '~1~2~3~',
            'userid'               => 5,
            'docid'                => 5,
            'status'               => 5
        ];

        $this->post('/api/v1/tongue-clinical-exams', $data)
            ->seeInDatabase('dental_ex_page1', ['blood_pressure' => '130/85'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tongue-clinical-exams/{id} -> TongueClinicalExamsController@update method
     * 
     */
    public function testUpdateTongueClinicalExam()
    {
        $tongueClinicalExamTestRecord = factory(TongueClinicalExam::class)->create();

        $data = [
            'additional_paragraph' => 'Update Test additional paragraph',
            'status'               => 8
        ];

        $this->put('/api/v1/tongue-clinical-exams/' . $tongueClinicalExamTestRecord->ex_page1id, $data)
            ->seeInDatabase('dental_ex_page1', ['additional_paragraph' => 'Update Test additional paragraph'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tongue-clinical-exams/{id} -> TongueClinicalExamsController@destroy method
     * 
     */
    public function testDeleteTongueClinicalExam()
    {
        $tongueClinicalExamTestRecord = factory(TongueClinicalExam::class)->create();

        $this->delete('/api/v1/tongue-clinical-exams/' . $tongueClinicalExamTestRecord->ex_page1id)
            ->notSeeInDatabase('dental_ex_page1', ['ex_page1id' => $tongueClinicalExamTestRecord->ex_page1id])
            ->assertResponseOk();
    }
}
