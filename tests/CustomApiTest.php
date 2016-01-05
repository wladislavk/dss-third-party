<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class CustomApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $customid;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/custom -> Api/ApiCustomController@store method
     * 
     */
    public function testAddCustom()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'title'        => ' test title custom',
            'description'  => 'added test description custom',
            'docid'        => 22222222,
            'status'       => 2,
            'default_text' => 2
        ];

        $this->post('/api/v1/custom', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_custom', ['description' => 'added test description custom']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/custom/{id} -> Api/ApiCustomController@update method
     * 
     */
    public function testUpdateCustom()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $customTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Custom::class)->create();

        $data = ['description' => 'updatedTestDescriptionCustom'];

        $this->put('/api/v1/custom/' . $customTestRecord->customid, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_custom', ['description' => 'updatedTestDescriptionCustom']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/custom/{id} -> Api/ApiCustomController@destroy method
     * 
     */
    public function testDeleteCustom()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $customTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\Custom::class)->create();

        $this->delete('/api/v1/custom/' . $customTestRecord->customid)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_custom', ['customid' => $customTestRecord->customid]);
    }
}
