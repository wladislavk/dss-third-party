<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\TransactionCode;

class TransactionCodesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/transaction-codes -> TransactionCodesController@store method
     * 
     */
    public function testAddTransactionCode()
    {
        $data = factory(TransactionCode::class)->make()->toArray();

        $data['docid'] = 100;

        $this->post('/api/v1/transaction-codes', $data)
            ->seeInDatabase('dental_transaction_code', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/transaction-codes/{id} -> TransactionCodesController@update method
     * 
     */
    public function testUpdateTransactionCode()
    {
        $transactionCodeTestRecord = factory(TransactionCode::class)->create();

        $data = [
            'description' => 'updated transaction code',
            'docid'       => 123
        ];

        $this->put('/api/v1/transaction-codes/' . $transactionCodeTestRecord->transaction_codeid, $data)
            ->seeInDatabase('dental_transaction_code', ['docid' => 123])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/transaction-codes/{id} -> TransactionCodesController@destroy method
     * 
     */
    public function testDeleteTransactionCode()
    {
        $transactionCodeTestRecord = factory(TransactionCode::class)->create();

        $this->delete('/api/v1/transaction-codes/' . $transactionCodeTestRecord->transaction_codeid)
            ->notSeeInDatabase('dental_transaction_code', [
                'transaction_codeid' => $transactionCodeTestRecord->transaction_codeid
            ])
            ->assertResponseOk();
    }
}
