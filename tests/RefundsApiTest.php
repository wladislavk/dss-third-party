<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Refund;

class RefundsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/refunds -> RefundsController@store method
     * 
     */
    public function testAddRefund()
    {
        $data = factory(Refund::class)->make()->toArray();

        $data['userid'] = 100;

        $this->post('/api/v1/refunds', $data)
            ->seeInDatabase('dental_refund', ['userid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/refunds/{id} -> RefundsController@update method
     * 
     */
    public function testUpdateRefund()
    {
        $refundTestRecord = factory(Refund::class)->create();

        $data = ['adminid' => 100];

        $this->put('/api/v1/refunds/' . $refundTestRecord->id, $data)
            ->seeInDatabase('dental_refund', ['adminid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/refunds/{id} -> RefundsController@destroy method
     * 
     */
    public function testDeleteRefund()
    {
        $refundTestRecord = factory(Refund::class)->create();

        $this->delete('/api/v1/refunds/' . $refundTestRecord->id)
            ->notSeeInDatabase('dental_refund', [
                'id' => $refundTestRecord->id
            ])
            ->assertResponseOk();
    }
}
