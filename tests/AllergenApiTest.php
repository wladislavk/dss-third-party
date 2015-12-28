<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AllergenApiTest extends TestCase
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
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'allergens'   => 'testAllergen',
            'description' => 'This is test description',
            'sortby'      => 12,
            'status'      => 2
        ];

        $this->post('/api/v1/allergen', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_allergens', ['allergens' => 'testAllergen']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/allergen/{id} -> Api/ApiAllergenController@update method
     * 
     */
    public function testUpdateAllergen()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $allergenTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Allergen::class)->create();

        $data = [
            'allergens'   => 'testUpdatedAllergen',
            'status'      => 5
        ];

        $this->put('/api/v1/allergen/' . $allergenTestRecord->allergensid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_allergens', ['allergens' => 'testUpdatedAllergen']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/allergen/{id} -> Api/ApiAllergenController@destroy method
     * 
     */
    public function testDeleteAllergen()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $allergenTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Allergen::class)->create();

        $this->delete('/api/v1/allergen/' . $allergenTestRecord->allergensid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_allergens', ['allergensid' => $allergenTestRecord->allergensid]);
    }
}
