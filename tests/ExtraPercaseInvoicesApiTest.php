<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\ExtraPercaseInvoice;

class ExtraPercaseInvoicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/extra-percase-invoices -> ExtraPercaseInvoicesController@store method
     * 
     */
    public function testAddExtraPercaseInvoice()
    {
        $data = factory(ExtraPercaseInvoice::class)->make()->toArray();

        $data['percase_invoice'] = 100;

        $this->post('/api/v1/extra-percase-invoices', $data)
            ->seeInDatabase('dental_percase_invoice_extra', ['percase_invoice' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/extra-percase-invoices/{id} -> ExtraPercaseInvoicesController@update method
     * 
     */
    public function testUpdateExtraPercaseInvoice()
    {
        $extraPercaseInvoiceTestRecord = factory(ExtraPercaseInvoice::class)->create();

        $data = [
            'percase_amount'  => 123.45,
            'percase_invoice' => 200
        ];

        $this->put('/api/v1/extra-percase-invoices/' . $extraPercaseInvoiceTestRecord->id, $data)
            ->seeInDatabase('dental_percase_invoice_extra', ['percase_invoice' => 200])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/extra-percase-invoices/{id} -> ExtraPercaseInvoicesController@destroy method
     * 
     */
    public function testDeleteExtraPercaseInvoice()
    {
        $extraPercaseInvoiceTestRecord = factory(ExtraPercaseInvoice::class)->create();

        $this->delete('/api/v1/extra-percase-invoices/' . $extraPercaseInvoiceTestRecord->id)
            ->notSeeInDatabase('dental_percase_invoice_extra', [
                'id' => $extraPercaseInvoiceTestRecord->id
            ])
            ->assertResponseOk();
    }
}
