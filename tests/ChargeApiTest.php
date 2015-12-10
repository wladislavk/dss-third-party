<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class ChargeApiTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseTransactions;

    protected $id;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/charge -> Api\ApiChargeController@store method
     * 
     */
    public function testAddCharge()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $data = [
            'userid'                  => 7,
            'adminid'                 => 10,
            'stripe_customer'         => 'testStripeCustomer',
            'amount'                  => 11.2,
            'charge_date'             => Carbon::now(),
            'stripe_customer'         => 'cus_1234567890123',
            'stripe_charge'           => 'ch_12345678901234567890',
            'stripe_card_fingerprint' => '123456789012345678901234567890',
            'adddate'                 => Carbon::now(),
            'ip_address'              => 127.0,
            'invoice_id'              => 44,
            'status'                  => 3
        ];

        dd($this->call("POST", '/api/v1/charge', $data));

        $this->post('/api/v1/charge', $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_charge', ['adminid' => 10]);
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/charge/{id} -> Api\ApiChargeController@update method
     * 
     */
    public function testUpdateCharge()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $chargeTestRecord = factory(DentalSleepSolutions\Models\Charge::class)->create();

        $data = [
            'adminid' => 20
        ];

        $this->put('/api/v1/charge/' . $chargeTestRecord->id, $data)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->seeInDatabase('dental_charge', ['adminid' => 20]);
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/charge/{id} -> Api\ApiChargeController@destroy method
     * 
     */
    public function testDeleteCharge()
    {
        $statusOk = Arr::get(Response::$statusTexts, 200);

        $chargeTestRecord = factory(DentalSleepSolutions\Models\Charge::class)->create();

        $this->delete('/api/v1/charge/' . $chargeTestRecord->id)
            ->seeStatusCode(200)
            ->seeJsonContains(['status' => $statusOk])
            ->notSeeInDatabase('dental_charge', ['id' => $chargeTestRecord->id]);
    }
}
