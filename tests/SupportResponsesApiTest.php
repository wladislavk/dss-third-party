<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SupportResponse;

class SupportResponsesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/support-responses -> SupportResponsesController@store method
     * 
     */
    public function testAddSupportResponse()
    {
        $data = factory(SupportResponse::class)->make()->toArray();

        $data['ticket_id'] = 100;

        $this->post('/api/v1/support-responses', $data)
            ->seeInDatabase('dental_support_responses', ['ticket_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/support-responses/{id} -> SupportResponsesController@update method
     * 
     */
    public function testUpdateSupportResponse()
    {
        $supportResponseTestRecord = factory(SupportResponse::class)->create();

        $data = [
            'responder_id' => 132,
            'body'         => 'support response body'
        ];

        $this->put('/api/v1/support-responses/' . $supportResponseTestRecord->id, $data)
            ->seeInDatabase('dental_support_responses', ['responder_id' => 132])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/support-responses/{id} -> SupportResponsesController@destroy method
     * 
     */
    public function testDeleteSupportResponse()
    {
        $supportResponseTestRecord = factory(SupportResponse::class)->create();

        $this->delete('/api/v1/support-responses/' . $supportResponseTestRecord->id)
            ->notSeeInDatabase('dental_support_responses', [
                'id' => $supportResponseTestRecord->id
            ])
            ->assertResponseOk();
    }
}
