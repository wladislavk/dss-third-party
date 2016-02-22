<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerStatement;

class LedgerStatementsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-statements -> LedgerStatementsController@store method
     * 
     */
    public function testAddLedgerStatement()
    {
        $data = factory(LedgerStatement::class)->make()->toArray();

        $data['producerid'] = 100;

        $this->post('/api/v1/ledger-statements', $data)
            ->seeInDatabase('dental_ledger_statement', ['producerid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-statements/{id} -> LedgerStatementsController@update method
     * 
     */
    public function testUpdateLedgerStatement()
    {
        $ledgerStatementTestRecord = factory(LedgerStatement::class)->create();

        $data = [
            'patientid'  => 50,
            'producerid' => 40
        ];

        $this->put('/api/v1/ledger-statements/' . $ledgerStatementTestRecord->id, $data)
            ->seeInDatabase('dental_ledger_statement', [
                'producerid' => 40
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-statements/{id} -> LedgerStatementsController@destroy method
     * 
     */
    public function testDeleteLedgerStatement()
    {
        $ledgerStatementTestRecord = factory(LedgerStatement::class)->create();

        $this->delete('/api/v1/ledger-statements/' . $ledgerStatementTestRecord->id)
            ->notSeeInDatabase('dental_ledger_statement', [
                'id' => $ledgerStatementTestRecord->id
            ])
            ->assertResponseOk();
    }
}