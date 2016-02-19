<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Ledger;

class LedgersApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledgers -> LedgersController@store method
     * 
     */
    public function testAddLedger()
    {
        $data = factory(Ledger::class)->make()->toArray();

        $data['patientid'] = 88;

        $this->post('/api/v1/ledgers', $data)
            ->seeInDatabase('dental_ledger', ['patientid' => 88])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledgers/{id} -> LedgersController@update method
     * 
     */
    public function testUpdateLedger()
    {
        $ledgerTestRecord = factory(Ledger::class)->create();

        $data = [
            'description' => 'updated test ledger',
            'amount'      => '177.53',
            'docid'       => 33
        ];

        $this->put('/api/v1/ledgers/' . $ledgerTestRecord->ledgerid, $data)
            ->seeInDatabase('dental_ledger', ['docid' => 33])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledgers/{id} -> LedgersController@destroy method
     * 
     */
    public function testDeleteLedger()
    {
        $ledgerTestRecord = factory(Ledger::class)->create();

        $this->delete('/api/v1/ledgers/' . $ledgerTestRecord->ledgerid)
            ->notSeeInDatabase('dental_ledger', [
                'ledgerid' => $ledgerTestRecord->ledgerid
            ])
            ->assertResponseOk();
    }
}
