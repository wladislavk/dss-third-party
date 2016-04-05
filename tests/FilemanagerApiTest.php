<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Filemanager;

class FilemanagerApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/filemanager -> FilemanagerController@store method
     * 
     */
    public function testAddFilemanager()
    {
        $data = factory(Filemanager::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/filemanager', $data)
            ->seeInDatabase('filemanager', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/filemanager/{id} -> FilemanagerController@update method
     * 
     */
    public function testUpdateFilemanager()
    {
        $filemanagerTestRecord = factory(Filemanager::class)->create();

        $data = [
            'name'  => 'Update_Name.jpg',
            'docid' => 7
        ];

        $this->put('/api/v1/filemanager/' . $filemanagerTestRecord->id, $data)
            ->seeInDatabase('filemanager', [
                'name' => 'Update_Name.jpg'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/filemanager/{id} -> FilemanagerController@destroy method
     * 
     */
    public function testDeleteFilemanager()
    {
        $filemanagerTestRecord = factory(Filemanager::class)->create();

        $this->delete('/api/v1/filemanager/' . $filemanagerTestRecord->id)
            ->notSeeInDatabase('filemanager', [
                'id' => $filemanagerTestRecord->id
            ])
            ->assertResponseOk();
    }
}
