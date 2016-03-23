<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\FaxInvoice;

class FaxInvoicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/fax-invoices -> FaxInvoicesController@store method
     * 
     */
    public function testAddFaxInvoice()
    {
        $data = factory(FaxInvoice::class)->make()->toArray();

        $data['invoice_id'] = 10;

        $this->post('/api/v1/fax-invoices', $data)
            ->seeInDatabase('dental_fax_invoice', ['invoice_id' => 10])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/fax-invoices/{id} -> FaxInvoicesController@update method
     * 
     */
    public function testUpdateFaxInvoice()
    {
        $faxInvoiceTestRecord = factory(FaxInvoice::class)->create();

        $data = [
            'invoice_id' => 100,
            'amount'     => 5.55
        ];

        $this->put('/api/v1/fax-invoices/' . $faxInvoiceTestRecord->id, $data)
            ->seeInDatabase('dental_fax_invoice', ['amount' => 5.55])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/fax-invoices/{id} -> FaxInvoicesController@destroy method
     * 
     */
    public function testDeleteFaxInvoice()
    {
        $faxInvoiceTestRecord = factory(FaxInvoice::class)->create();

        $this->delete('/api/v1/fax-invoices/' . $faxInvoiceTestRecord->id)
            ->notSeeInDatabase('dental_fax_invoice', [
                'id' => $faxInvoiceTestRecord->id
            ])
            ->assertResponseOk();
    }
}
