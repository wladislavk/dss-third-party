<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerPayment;

class LedgerPaymentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-payments -> LedgerPaymentsController@store method
     * 
     */
    public function testAddLedgerPayment()
    {
        $data = factory(LedgerPayment::class)->make()->toArray();

        $data['ledgerid'] = 123;

        $this->post('/api/v1/ledger-payments', $data)
            ->seeInDatabase('dental_ledger_payment', ['ledgerid' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-payments/{id} -> LedgerPaymentsController@update method
     * 
     */
    public function testUpdateLedgerPayment()
    {
        $ledgerPaymentTestRecord = factory(LedgerPayment::class)->create();

        $data = [
            'amount'   => 123.4,
            'ledgerid' => 3,
            'note'     => 'updated test ledger payment'
        ];

        $this->put('/api/v1/ledger-payments/' . $ledgerPaymentTestRecord->id, $data)
            ->seeInDatabase('dental_ledger_payment', ['ledgerid' => 3])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-payments/{id} -> LedgerPaymentsController@destroy method
     * 
     */
    public function testDeleteLedgerPayment()
    {
        $ledgerPaymentTestRecord = factory(LedgerPayment::class)->create();

        $this->delete('/api/v1/ledger-payments/' . $ledgerPaymentTestRecord->id)
            ->notSeeInDatabase('dental_ledger_payment', [
                'id' => $ledgerPaymentTestRecord->id
            ])
            ->assertResponseOk();
    }
}
