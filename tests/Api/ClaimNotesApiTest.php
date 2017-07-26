<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ClaimNote;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCases\ApiTestCase;

class ClaimNotesApiTest extends ApiTestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/claim-notes -> Api/ApiClaimNotesController@store method
     * 
     */
    public function testAddClaimNote()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'claim_id'    => 5,
            'create_type' => 0,
            'creator_id'  => 5,
            'note'        => 'testNote'
        ];

        $this->post('/api/v1/claim-notes', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_notes', ['note' => 'testNote']);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/claim-notes/{id} -> Api/ApiClaimNotesController@update method
     * 
     */
    public function testUpdateClaimNote()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimNoteTestRecord = factory(ClaimNote::class)->create();

        $data = [
            'note' => 'updatedTestNote'
        ];

        $this->put('/api/v1/claim-notes/' . $claimNoteTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_claim_notes', ['note' => 'updatedTestNote']);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/claim-notes/{id} -> Api/ApiClaimNotesController@destroy method
     * 
     */
    public function testDeleteClaimNote()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $claimNoteTestRecord = factory(ClaimNote::class)->create();

        $this->delete('/api/v1/claim-notes/' . $claimNoteTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_claim_notes', ['id' => $claimNoteTestRecord->id]);
    }
}
