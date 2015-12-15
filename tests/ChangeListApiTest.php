<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ChangeListApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/change-list-> Api/ApiChangeListController@store method
     * 
     */
    public function testAddChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = ['content' => 'testContent'];

        $this->post('/api/v1/change-list', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_change_list', ['content' => 'testContent']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/change-list/{id} -> Api/ApiChangeListController@update method
     * 
     */
    public function testUpdateChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $changeListTestRecord = factory(DentalSleepSolutions\Models\ChangeList::class)->create();

        $data = ['content' => 'updatedTestContent'];

        $this->put('/api/v1/change-list/' . $changeListTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_change_list', ['content' => 'updatedTestContent']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/change-list/{id} -> Api/ApiChangeListController@destroy method
     * 
     */
    public function testDeleteChangeList()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $changeListTestRecord = factory(DentalSleepSolutions\Models\ChangeList::class)->create();

        $this->delete('/api/v1/change-list/' . $changeListTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_change_list', ['id' => $changeListTestRecord->id]);
    }
}
