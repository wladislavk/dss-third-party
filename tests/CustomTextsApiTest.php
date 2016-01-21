<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\CustomText;

class CustomsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/custom-texts -> CustomTextsController@store method
     * 
     */
    public function testAddCustom()
    {
        $data = [
            'title'        => 'test title custom',
            'description'  => 'added test description custom',
            'docid'        => 10,
            'status'       => 2,
            'default_text' => 2
        ];

        $this->post('/api/v1/custom-texts', $data)
            ->seeInDatabase('dental_custom', ['description' => 'added test description custom'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/custom-texts/{id} -> CustomTextsController@update method
     * 
     */
    public function testUpdateCustom()
    {
        $customTestRecord = factory(CustomText::class)->create();

        $data = ['description' => 'updatedTestDescriptionCustom'];

        $this->put('/api/v1/custom-texts/' . $customTestRecord->customid, $data)
            ->seeInDatabase('dental_custom', ['description' => 'updatedTestDescriptionCustom'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/custom-texts/{id} -> CustomTextsController@destroy method
     * 
     */
    public function testDeleteCustom()
    {
        $customTestRecord = factory(CustomText::class)->create();

        $this->delete('/api/v1/custom-texts/' . $customTestRecord->customid)
            ->notSeeInDatabase('dental_custom', ['customid' => $customTestRecord->customid])
            ->assertResponseOk();
    }
}
