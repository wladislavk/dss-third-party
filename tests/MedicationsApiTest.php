<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Medicament;

class MedicationsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/medications -> MedicationsController@store method
     * 
     */
    public function testAddMedicament()
    {
        $data = factory(Medicament::class)->make()->toArray();

        $data['status'] = 7;

        $this->post('/api/v1/medications', $data)
            ->seeInDatabase('dental_medications', ['status' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/medications/{id} -> MedicationsController@update method
     * 
     */
    public function testUpdateMedicament()
    {
        $medicamentTestRecord = factory(Medicament::class)->create();

        $data = [
            'description' => 'updated medicament',
            'sortby'      => 123
        ];

        $this->put('/api/v1/medications/' . $medicamentTestRecord->medicationsid, $data)
            ->seeInDatabase('dental_medications', ['sortby' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/medications/{id} -> MedicationsController@destroy method
     * 
     */
    public function testDeleteMedicament()
    {
        $medicamentTestRecord = factory(Medicament::class)->create();

        $this->delete('/api/v1/medications/' . $medicamentTestRecord->medicationsid)
            ->notSeeInDatabase('dental_medications', [
                'medicationsid' => $medicamentTestRecord->medicationsid
            ])
            ->assertResponseOk();
    }
}
