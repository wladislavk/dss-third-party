<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Task;

class TasksApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/tasks -> TasksController@store method
     * 
     */
    public function testAddTask()
    {
        $data = factory(Task::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/tasks', $data)
            ->seeInDatabase('dental_task', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/tasks/{id} -> TasksController@update method
     * 
     */
    public function testUpdateTask()
    {
        $taskTestRecord = factory(Task::class)->create();

        $data = [
            'patientid'   => 100,
            'description' => 'updated task'
        ];

        $this->put('/api/v1/tasks/' . $taskTestRecord->id, $data)
            ->seeInDatabase('dental_task', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/tasks/{id} -> TasksController@destroy method
     * 
     */
    public function testDeleteTask()
    {
        $taskTestRecord = factory(Task::class)->create();

        $this->delete('/api/v1/tasks/' . $taskTestRecord->id)
            ->notSeeInDatabase('dental_task', [
                'id' => $taskTestRecord->id
            ])
            ->assertResponseOk();
    }
}
