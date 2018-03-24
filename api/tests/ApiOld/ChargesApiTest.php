<?php
namespace Tests\Api;

use Carbon\Carbon;
use DentalSleepSolutions\Eloquent\Models\Dental\Charge;
use Tests\TestCases\ApiTestCase;

class ChargesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Charge::class;
    }

    protected function getRoute()
    {
        return '/charges';
    }

    protected function getStoreData()
    {
        return [
            'amount'                  => 12.21,
            'userid'                  => 7,
            'adminid'                 => 7,
            'charge_date'             => Carbon::now(),
            'stripe_customer'         => 'testStripeCustomer',
            'stripe_charge'           => 'ch_12345678901234567890',
            'stripe_card_fingerprint' => '123456789012345678901234567890',
            'invoice_id'              => 7,
            'status'                  => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'stripe_customer' => 'updatedTestStripeCustomer',
            'adminid'         => 10,
        ];
    }
}
