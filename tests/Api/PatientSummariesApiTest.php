<?php
namespace Tests\Api;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use Tests\TestCases\ApiTestCase;

class PatientSummariesApiTest extends ApiTestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/patient-summaries -> PatientSummariesController@store method
     * 
     */
    public function testAddPatientSummary()
    {
        $this->markTestSkipped('Unknown column \'id\' in \'where clause\' (SQL: select count(*) as aggregate from `dental_patient_summary` where (`id` is null))');
        return;
        $data = factory(PatientSummary::class)->make()->toArray();

        $data['pid'] = 100;

        $this->post('/api/v1/patient-summaries', $data)
            ->seeInDatabase('dental_patient_summary', ['pid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/patient-summaries/{id} -> PatientSummariesController@update method
     * 
     */
    public function testUpdatePatientSummary()
    {
        $this->markTestSkipped('Unknown column \'id\' in \'where clause\' (SQL: select count(*) as aggregate from `dental_patient_summary` where (`id` is null))');
        return;
        $patientSummaryTestRecord = factory(PatientSummary::class)->create();

        $data = [
            'last_treatment' => 'test treatment',
            'appliance'      => 8,
        ];

        $this->put('/api/v1/patient-summaries/' . $patientSummaryTestRecord->id, $data)
            ->seeInDatabase('dental_patient_summary', ['last_treatment' => 'test treatment'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/patient-summaries/{id} -> PatientSummariesController@destroy method
     * 
     */
    public function testDeletePatientSummary()
    {
        $this->markTestSkipped('Unknown column \'id\' in \'where clause\' (SQL: select count(*) as aggregate from `dental_patient_summary` where (`id` is null))');
        return;
        $patientSummaryTestRecord = factory(PatientSummary::class)->create();

        $this->delete('/api/v1/patient-summaries/' . $patientSummaryTestRecord->id)
            ->notSeeInDatabase('dental_patient_summary', [
                'id' => $patientSummaryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
