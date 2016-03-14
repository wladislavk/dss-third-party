<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Recipient;

class RecipientsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/recipients -> RecipientsController@store method
     * 
     */
    public function testAddRecipient()
    {
        $data = factory(Recipient::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/recipients', $data)
            ->seeInDatabase('dental_q_recipients', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/recipients/{id} -> RecipientsController@update method
     * 
     */
    public function testUpdateRecipient()
    {
        $recipientTestRecord = factory(Recipient::class)->create();

        $data = [
            'formid'       => 100,
            'patient_info' => 'updated patient info'
        ];

        $this->put('/api/v1/recipients/' . $recipientTestRecord->q_recipientsid, $data)
            ->seeInDatabase('dental_q_recipients', ['formid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/recipients/{id} -> RecipientsController@destroy method
     * 
     */
    public function testDeleteRecipient()
    {
        $recipientTestRecord = factory(Recipient::class)->create();

        $this->delete('/api/v1/recipients/' . $recipientTestRecord->q_recipientsid)
            ->notSeeInDatabase('dental_q_recipients', [
                'q_recipientsid' => $recipientTestRecord->q_recipientsid
            ])
            ->assertResponseOk();
    }
}
