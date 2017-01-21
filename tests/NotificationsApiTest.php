<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Notification;

class NotificationsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/notifications -> NotificationsController@store method
     * 
     */
    public function testAddNotification()
    {
        $data = factory(Notification::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/notifications', $data)
            ->seeInDatabase('dental_notifications', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/notifications/{id} -> NotificationsController@update method
     * 
     */
    public function testUpdateNotification()
    {
        $notificationTestRecord = factory(Notification::class)->create();

        $data = [
            'docid'        => 100,
            'notification' => 'updated notification'
        ];

        $this->put('/api/v1/notifications/' . $notificationTestRecord->id, $data)
            ->seeInDatabase('dental_notifications', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/notifications/{id} -> NotificationsController@destroy method
     * 
     */
    public function testDeleteNotification()
    {
        $notificationTestRecord = factory(Notification::class)->create();

        $this->delete('/api/v1/notifications/' . $notificationTestRecord->id)
            ->notSeeInDatabase('dental_notifications', [
                'id' => $notificationTestRecord->id
            ])
            ->assertResponseOk();
    }
}
