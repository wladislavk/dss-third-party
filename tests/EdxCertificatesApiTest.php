<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\EdxCertificat;

class EdxCertificatesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/edx-certificates -> EdxCertificatesController@store method
     * 
     */
    public function testAddEdxCertificat()
    {
        $data = factory(EdxCertificat::class)->make()->toArray();

        $data['number_ce'] = 8;

        $this->post('/api/v1/edx-certificates', $data)
            ->seeInDatabase('edx_certificates', ['number_ce' => 8])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/edx-certificates/{id} -> EdxCertificatesController@update method
     * 
     */
    public function testUpdateEdxCertificat()
    {
        $edxCertificatTestRecord = factory(EdxCertificat::class)->create();

        $data = [
            'course_name' => 'updated course name',
            'number_ce'   => 9
        ];

        $this->put('/api/v1/edx-certificates/' . $edxCertificatTestRecord->id, $data)
            ->seeInDatabase('edx_certificates', [
                'course_name' => 'updated course name'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/edx-certificates/{id} -> EdxCertificatesController@destroy method
     * 
     */
    public function testDeleteEdxCertificat()
    {
        $edxCertificatTestRecord = factory(EdxCertificat::class)->create();

        $this->delete('/api/v1/edx-certificates/' . $edxCertificatTestRecord->id)
            ->notSeeInDatabase('edx_certificates', [
                'id' => $edxCertificatTestRecord->id
            ])
            ->assertResponseOk();
    }
}
