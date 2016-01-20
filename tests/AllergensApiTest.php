<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Allergen;

class AllergenApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/allergens -> AllergensController@store method
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

        $this->post('/api/v1/allergens', $data)
            ->seeInDatabase('dental_allergens', ['allergens' => 'testAllergen'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/allergens/{id} -> AllergensController@update method
     * 
     */
    public function testUpdateAllergen()
    {
        $allergenTestRecord = factory(Allergen::class)->create();

        $data = [
            'allergens'   => 'testUpdatedAllergen',
            'status'      => 5
        ];

        $this->put('/api/v1/allergens/' . $allergenTestRecord->allergensid, $data)
            ->seeInDatabase('dental_allergens', ['allergens' => 'testUpdatedAllergen'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/allergens/{id} -> AllergensController@destroy method
     * 
     */
    public function testDeleteAllergen()
    {
        $allergenTestRecord = factory(Allergen::class)->create();

        $this->delete('/api/v1/allergens/' . $allergenTestRecord->allergensid)
            ->notSeeInDatabase('dental_allergens', ['allergensid' => $allergenTestRecord->allergensid])
            ->assertResponseOk();
    }
}
