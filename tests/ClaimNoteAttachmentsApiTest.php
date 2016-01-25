<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ClaimNoteAttachmentsApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/claim-note-attachments -> Api/ApiClaimNoteAttachmentsController@store method
     * 
     */
    public function testAddClaimNoteAttachment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'note_id'  => 5,
            'filename' => 'testFilename'
        ];

        $this->post('/api/v1/claim-note-attachments', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_note_attachment', ['note_id' => 5]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/claim-note-attachments/{id} -> Api/ApiClaimNoteAttachmentsController@update method
     * 
     */
    public function testUpdateClaimNoteAttachment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimNoteAttachmentTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment::class)->create();

        $data = [
            'filename' => 'updatedTestFilename'
        ];

        $this->put('/api/v1/claim-note-attachments/' . $claimNoteAttachmentTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_note_attachment', ['filename' => 'updatedTestFilename']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/claim-note-attachments/{id} -> Api/ApiClaimNoteAttachmentsController@destroy method
     * 
     */
    public function testDeleteClaimNoteAttachment()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimNoteAttachmentTestRecord = factory(DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment::class)->create();

        $this->delete('/api/v1/claim-note-attachments/' . $claimNoteAttachmentTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_claim_note_attachment', ['id' => $claimNoteAttachmentTestRecord->id]);
    }
}
