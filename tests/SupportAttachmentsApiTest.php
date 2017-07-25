<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SupportAttachment;

class SupportAttachmentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/support-attachments -> SupportAttachmentsController@store method
     * 
     */
    public function testAddSupportAttachment()
    {
        $data = factory(SupportAttachment::class)->make()->toArray();

        $data['ticket_id'] = 100;

        $this->post('/api/v1/support-attachments', $data)
            ->seeInDatabase('dental_support_attachment', ['ticket_id' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/support-attachments/{id} -> SupportAttachmentsController@update method
     * 
     */
    public function testUpdateSupportAttachment()
    {
        $supportAttachmentTestRecord = factory(SupportAttachment::class)->create();

        $data = ['response_id' => 132];

        $this->put('/api/v1/support-attachments/' . $supportAttachmentTestRecord->id, $data)
            ->seeInDatabase('dental_support_attachment', ['response_id' => 132])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/support-attachments/{id} -> SupportAttachmentsController@destroy method
     * 
     */
    public function testDeleteSupportAttachment()
    {
        $supportAttachmentTestRecord = factory(SupportAttachment::class)->create();

        $this->delete('/api/v1/support-attachments/' . $supportAttachmentTestRecord->id)
            ->notSeeInDatabase('dental_support_attachment', [
                'id' => $supportAttachmentTestRecord->id
            ])
            ->assertResponseOk();
    }
}
