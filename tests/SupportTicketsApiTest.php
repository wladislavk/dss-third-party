<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SupportTicket;

class SupportTicketsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/support-tickets -> SupportTicketsController@store method
     * 
     */
    public function testAddSupportTicket()
    {
        $data = factory(SupportTicket::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/support-tickets', $data)
            ->seeInDatabase('dental_support_tickets', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/support-tickets/{id} -> SupportTicketsController@update method
     * 
     */
    public function testUpdateSupportTicket()
    {
        $supportTicketTestRecord = factory(SupportTicket::class)->create();

        $data = [
            'docid' => 100,
            'body'  => 'updated support ticket'
        ];

        $this->put('/api/v1/support-tickets/' . $supportTicketTestRecord->id, $data)
            ->seeInDatabase('dental_support_tickets', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/support-tickets/{id} -> SupportTicketsController@destroy method
     * 
     */
    public function testDeleteSupportTicket()
    {
        $supportTicketTestRecord = factory(SupportTicket::class)->create();

        $this->delete('/api/v1/support-tickets/' . $supportTicketTestRecord->id)
            ->notSeeInDatabase('dental_support_tickets', [
                'id' => $supportTicketTestRecord->id
            ])
            ->assertResponseOk();
    }
}
