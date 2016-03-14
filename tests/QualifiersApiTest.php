<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Qualifier;

class QualifiersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/qualifiers -> QualifiersController@store method
     * 
     */
    public function testAddQualifier()
    {
        $data = factory(Qualifier::class)->make()->toArray();

        $data['sortby'] = 234;

        $this->post('/api/v1/qualifiers', $data)
            ->seeInDatabase('dental_qualifier', ['sortby' => 234])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/qualifiers/{id} -> QualifiersController@update method
     * 
     */
    public function testUpdateQualifier()
    {
        $qualifierTestRecord = factory(Qualifier::class)->create();

        $data = [
            'description' => 'updated qualifier',
            'status'      => 5
        ];

        $this->put('/api/v1/qualifiers/' . $qualifierTestRecord->qualifierid, $data)
            ->seeInDatabase('dental_qualifier', ['status' => 5])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/qualifiers/{id} -> QualifiersController@destroy method
     * 
     */
    public function testDeleteQualifier()
    {
        $qualifierTestRecord = factory(Qualifier::class)->create();

        $this->delete('/api/v1/qualifiers/' . $qualifierTestRecord->qualifierid)
            ->notSeeInDatabase('dental_qualifier', [
                'qualifierid' => $qualifierTestRecord->qualifierid
            ])
            ->assertResponseOk();
    }
}
