<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory;

class LedgerPaymentHistoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/ledger-payment-histories -> LedgerPaymentHistoriesController@store method
     * 
     */
    public function testAddLedgerPaymentHistory()
    {
        $data = factory(LedgerPaymentHistory::class)->make()->toArray();

        $data['paymentid'] = 100;

        $this->post('/api/v1/ledger-payment-histories', $data)
            ->seeInDatabase('dental_ledger_payment_history', ['paymentid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/ledger-payment-histories/{id} -> LedgerPaymentHistoriesController@update method
     * 
     */
    public function testUpdateLedgerPaymentHistory()
    {
        $ledgerPaymentHistoryTestRecord = factory(LedgerPaymentHistory::class)->create();

        $data = [
            'note'  => 'updated ledger payment history',
            'payer' => 8
        ];

        $this->put('/api/v1/ledger-payment-histories/' . $ledgerPaymentHistoryTestRecord->id, $data)
            ->seeInDatabase('dental_ledger_payment_history', [
                'note' => 'updated ledger payment history'
            ])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/ledger-payment-histories/{id} -> LedgerPaymentHistoriesController@destroy method
     * 
     */
    public function testDeleteLedgerPaymentHistory()
    {
        $ledgerPaymentHistoryTestRecord = factory(LedgerPaymentHistory::class)->create();

        $this->delete('/api/v1/ledger-payment-histories/' . $ledgerPaymentHistoryTestRecord->id)
            ->notSeeInDatabase('dental_ledger_payment_history', [
                'id' => $ledgerPaymentHistoryTestRecord->id
            ])
            ->assertResponseOk();
    }
}