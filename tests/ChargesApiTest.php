<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

use DentalSleepSolutions\Eloquent\Dental\Charge;

class ChargesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/charges -> ChargesController@store method
     * 
     */
    public function testAddCharge()
    {
        $data = [
            'amount'                  => 12.21,
            'userid'                  => 7,
            'adminid'                 => 7,
            'charge_date'             => Carbon::now(),
            'stripe_customer'         => 'testStripeCustomer',
            'stripe_charge'           => 'ch_12345678901234567890',
            'stripe_card_fingerprint' => '123456789012345678901234567890',
            'invoice_id'              => 7,
            'status'                  => 7
        ];

        $this->post('/api/v1/charges', $data)
            ->seeInDatabase('dental_charge', ['stripe_customer' => 'testStripeCustomer'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/charges/{id} -> ChargesController@update method
     * 
     */
    public function testUpdateCharge()
    {
        $chargeTestRecord = factory(Charge::class)->create();

        $data = [
            'stripe_customer' => 'updatedTestStripeCustomer',
            'adminid'         => 10
        ];

        $this->put('/api/v1/charges/' . $chargeTestRecord->id, $data)
            ->seeInDatabase('dental_charge', ['stripe_customer' => 'updatedTestStripeCustomer'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/charges/{id} -> ChargesController@destroy method
     * 
     */
    public function testDeleteCharge()
    {
        $chargeTestRecord = factory(Charge::class)->create();

        $this->delete('/api/v1/charges/' . $chargeTestRecord->id)
            ->notSeeInDatabase('dental_charge', ['id' => $chargeTestRecord->id])
            ->assertResponseOk();
    }
}
