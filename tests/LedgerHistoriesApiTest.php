<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerHistory;

class LedgerHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-histories -> LedgerHistoriesController@store method
     * 
     */
    public function testAddLedgerHistory()
    {
        $data = factory(LedgerHistory::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/ledger-histories', $data)
            ->seeInDatabase('dental_ledger_history', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-histories/{id} -> LedgerHistoriesController@update method
     * 
     */
    public function testUpdateLedgerHistory()
    {
        $ledgerHistoryTestRecord = factory(LedgerHistory::class)->create();

        $data = [
            'description' => 'updated ledger history',
            'status'      => 5
        ];

        $this->put('/api/v1/ledger-histories/' . $ledgerHistoryTestRecord->id, $data)
            ->seeInDatabase('dental_ledger_history', [
                'description' => 'updated ledger history'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-histories/{id} -> LedgerHistoriesController@destroy method
     * 
     */
    public function testDeleteLedgerHistory()
    {
        $ledgerHistoryTestRecord = factory(LedgerHistory::class)->create();

        $this->delete('/api/v1/ledger-histories/' . $ledgerHistoryTestRecord->id)
            ->notSeeInDatabase('dental_ledger_history', [
                'id' => $ledgerHistoryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
