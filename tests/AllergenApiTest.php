<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AllergenAipTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $allergensid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/allergen -> Api/ApiAllergenController@store method
     * 
     */
    public function testAddAllergen()
    {
        $data = [
            'allergens'   => 'testAllergen',
            'description' => 'This is test description',
            'sortby'      => 12,
            'status'      => 2
        ];

        $this->post('/api/v1/allergen', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('dental_allergens', ['allergens' => 'testAllergen']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/allergen/{id} -> Api/ApiAllergenController@update method
     * 
     */
    public function testUpdateAllergen()
    {
        $allergenTestRecord = factory(DentalSleepSolutions\Models\Allergen::class)->create();

        $data = [
            'allergens'   => 'testUpdatedAllergen',
            'status'      => 5
        ];

        $this->put('/api/v1/allergen/' . $allergenTestRecord->allergensid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->seeInDatabase('dental_allergens', ['allergens' => 'testUpdatedAllergen']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/allergen/{id} -> Api/ApiAllergenController@destroy method
     * 
     */
    public function testDeleteAllergen()
    {
        $allergenTestRecord = factory(DentalSleepSolutions\Models\Allergen::class)->create();

        $this->delete('/api/v1/allergen/' . $allergenTestRecord->allergensid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => true])
            ->notSeeInDatabase('dental_allergens', ['allergensid' => $allergenTestRecord->allergensid]);
    }
}
