<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam;
use Tests\TestCases\ApiTestCase;

class TonsilsClinicalExamsApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tonsils-clinical-exams -> TonsilsClinicalExamsController@store method
     * 
     */
    public function testAddTonsilsClinicalExam()
    {
        $this->markTestSkipped('Column \'parent_patientid\' does not exist in the DB');
        return;
        $data = factory(TonsilsClinicalExam::class)->make()->toArray();

        $data['formid'] = 100;

        $this->post('/api/v1/tonsils-clinical-exams', $data)
            ->seeInDatabase('dental_ex_page2', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tonsils-clinical-exams/{id} -> TonsilsClinicalExamsController@update method
     * 
     */
    public function testUpdateTonsilsClinicalExam()
    {
        $this->markTestSkipped('Column \'parent_patientid\' does not exist in the DB');
        return;
        $tonsilsClinicalExamTestRecord = factory(TonsilsClinicalExam::class)->create();

        $data = ['docid' => 100];

        $this->put('/api/v1/tonsils-clinical-exams/' . $tonsilsClinicalExamTestRecord->ex_page2id, $data)
            ->seeInDatabase('dental_ex_page2', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tonsils-clinical-exams/{id} -> TonsilsClinicalExamsController@destroy method
     * 
     */
    public function testDeleteTonsilsClinicalExam()
    {
        $this->markTestSkipped('Column \'parent_patientid\' does not exist in the DB');
        return;
        $tonsilsClinicalExamTestRecord = factory(TonsilsClinicalExam::class)->create();

        $this->delete('/api/v1/tonsils-clinical-exams/' . $tonsilsClinicalExamTestRecord->ex_page2id)
            ->notSeeInDatabase('dental_ex_page2', [
                'ex_page2id' => $tonsilsClinicalExamTestRecord->ex_page2id
            ])
            ->assertResponseOk();
    }
}
