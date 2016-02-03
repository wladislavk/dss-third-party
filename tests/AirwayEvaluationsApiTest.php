<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation;

class AirwayEvaluationsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/airway-evaluations -> AirwayEvaluationsController@store method
     * 
     */
    public function testAddAirwayEvaluation()
    {
        $data = [
            'formid'               => 7,
            'patientid'            => 7,
            'maxilla'              => '~7~8~',
            'other_maxilla'        => 'test other maxilla',
            'mandible'             => '~7~8~',
            'other_mandible'       => 'test other mandible',
            'soft_palate'          => '~7~8~',
            'other_soft_palate'    => 'test other soft palate',
            'uvula'                => '~7~8~',
            'other_uvula'          => 'test other uvula',
            'gag_reflex'           => '~7~8~',
            'other_gag_reflex'     => 'test other gag reflex',
            'nasal_passages'       => '~7~8~',
            'other_nasal_passages' => 'test other nasal passages',
            'userid'               => 7,
            'docid'                => 7,
            'status'               => 7
        ];

        $this->post('/api/v1/airway-evaluations', $data)
            ->seeInDatabase('dental_ex_page3', ['other_mandible' => 'test other mandible'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/airway-evaluations/{id} -> AirwayEvaluationsController@update method
     * 
     */
    public function testUpdateAirwayEvaluation()
    {
        $airwayEvaluationTestRecord = factory(AirwayEvaluation::class)->create();

        $data = [
            'other_mandible' => 'update test other mandible',
            'status'         => 8
        ];

        $this->put('/api/v1/airway-evaluations/' . $airwayEvaluationTestRecord->ex_page3id, $data)
            ->seeInDatabase('dental_ex_page3', ['other_mandible' => 'update test other mandible'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/airway-evaluations/{id} -> AirwayEvaluationsController@destroy method
     * 
     */
    public function testDeleteAirwayEvaluation()
    {
        $airwayEvaluationTestRecord = factory(AirwayEvaluation::class)->create();

        $this->delete('/api/v1/airway-evaluations/' . $airwayEvaluationTestRecord->ex_page3id)
            ->notSeeInDatabase('dental_ex_page3', ['ex_page3id' => $airwayEvaluationTestRecord->ex_page3id])
            ->assertResponseOk();
    }
}
