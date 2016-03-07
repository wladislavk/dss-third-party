<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PaymentReport;

class PaymentReportsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/payment-reports -> PaymentReportsController@store method
     * 
     */
    public function testAddPaymentReport()
    {
        $data = factory(PaymentReport::class)->make()->toArray();

        $data['claimid'] = 100;

        $this->post('/api/v1/payment-reports', $data)
            ->seeInDatabase('dental_payment_reports', ['claimid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/payment-reports/{id} -> PaymentReportsController@update method
     * 
     */
    public function testUpdatePaymentReport()
    {
        $paymentReportTestRecord = factory(PaymentReport::class)->create();

        $data = [
            'claimid'      => 54,
            'reference_id' => 'ABC123DEF456',
            'viewed'       => 1
        ];

        $this->put('/api/v1/payment-reports/' . $paymentReportTestRecord->payment_id, $data)
            ->seeInDatabase('dental_payment_reports', ['claimid' => 54])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/payment-reports/{id} -> PaymentReportsController@destroy method
     * 
     */
    public function testDeletePaymentReport()
    {
        $paymentReportTestRecord = factory(PaymentReport::class)->create();

        $this->delete('/api/v1/payment-reports/' . $paymentReportTestRecord->payment_id)
            ->notSeeInDatabase('dental_payment_reports', [
                'payment_id' => $paymentReportTestRecord->payment_id
            ])
            ->assertResponseOk();
    }
}