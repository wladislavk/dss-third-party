<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ChangeListsApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/change-lists-> Api/ApiChangeListsController@store method
     * 
     */
    public function testAddChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = ['content' => 'testContent'];

        $this->post('/api/v1/change-lists', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_change_list', ['content' => 'testContent']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/change-lists/{id} -> Api/ApiChangeListsController@update method
     * 
     */
    public function testUpdateChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $changeListTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ChangeList::class)->create();

        $data = ['content' => 'updatedTestContent'];

        $this->put('/api/v1/change-lists/' . $changeListTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_change_list', ['content' => 'updatedTestContent']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/change-lists/{id} -> Api/ApiChangeListsController@destroy method
     * 
     */
    public function testDeleteChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $changeListTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ChangeList::class)->create();

        $this->delete('/api/v1/change-lists/' . $changeListTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_change_list', ['id' => $changeListTestRecord->id]);
    }
}
