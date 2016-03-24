<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerNote;

class LedgerNotesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-notes -> LedgerNotesController@store method
     * 
     */
    public function testAddLedgerNote()
    {
        $data = factory(LedgerNote::class)->make()->toArray();

        $data['producerid'] = 100;

        $this->post('/api/v1/ledger-notes', $data)
            ->seeInDatabase('dental_ledger_note', ['producerid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-notes/{id} -> LedgerNotesController@update method
     * 
     */
    public function testUpdateLedgerNote()
    {
        $ledgerNoteTestRecord = factory(LedgerNote::class)->create();

        $data = [
            'note'    => 'updated note',
            'private' => 8
        ];

        $this->put('/api/v1/ledger-notes/' . $ledgerNoteTestRecord->id, $data)
            ->seeInDatabase('dental_ledger_note', [
                'note' => 'updated note'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-notes/{id} -> LedgerNotesController@destroy method
     * 
     */
    public function testDeleteLedgerNote()
    {
        $ledgerNoteTestRecord = factory(LedgerNote::class)->create();

        $this->delete('/api/v1/ledger-notes/' . $ledgerNoteTestRecord->id)
            ->notSeeInDatabase('dental_ledger_note', [
                'id' => $ledgerNoteTestRecord->id
            ])
            ->assertResponseOk();
    }
}
