<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerRecord;

class LedgerRecordsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-records -> LedgerRecordsController@store method
     * 
     */
    public function testAddLedgerRecord()
    {
        $data = factory(LedgerRecord::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/ledger-records', $data)
            ->seeInDatabase('dental_ledger_rec', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-records/{id} -> LedgerRecordsController@update method
     * 
     */
    public function testUpdateLedgerRecord()
    {
        $ledgerRecordTestRecord = factory(LedgerRecord::class)->create();

        $data = [
            'description' => 'updated description ledger record',
            'status'      => 8
        ];

        $this->put('/api/v1/ledger-records/' . $ledgerRecordTestRecord->ledgerid, $data)
            ->seeInDatabase('dental_ledger_rec', [
                'description' => 'updated description ledger record'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-records/{id} -> LedgerRecordsController@destroy method
     * 
     */
    public function testDeleteLedgerRecord()
    {
        $ledgerRecordTestRecord = factory(LedgerRecord::class)->create();

        $this->delete('/api/v1/ledger-records/' . $ledgerRecordTestRecord->ledgerid)
            ->notSeeInDatabase('dental_ledger_rec', [
                'ledgerid' => $ledgerRecordTestRecord->ledgerid
            ])
            ->assertResponseOk();
    }
}
