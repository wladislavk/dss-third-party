<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\PercaseInvoice;

class PercaseInvoicesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/percase-invoices -> PercaseInvoicesController@store method
     * 
     */
    public function testAddPercaseInvoice()
    {
        $data = factory(PercaseInvoice::class)->make()->toArray();

        $data['adminid'] = 100;

        $this->post('/api/v1/percase-invoices', $data)
            ->seeInDatabase('dental_percase_invoice', ['adminid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/percase-invoices/{id} -> PercaseInvoicesController@update method
     * 
     */
    public function testUpdatePercaseInvoice()
    {
        $percaseInvoiceTestRecord = factory(PercaseInvoice::class)->create();

        $data = [
            'docid'         => 100,
            'user_fee_desc' => 'updated percase invoice'
        ];

        $this->put('/api/v1/percase-invoices/' . $percaseInvoiceTestRecord->id, $data)
            ->seeInDatabase('dental_percase_invoice', ['docid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/percase-invoices/{id} -> PercaseInvoicesController@destroy method
     * 
     */
    public function testDeletePercaseInvoice()
    {
        $percaseInvoiceTestRecord = factory(PercaseInvoice::class)->create();

        $this->delete('/api/v1/percase-invoices/' . $percaseInvoiceTestRecord->id)
            ->notSeeInDatabase('dental_percase_invoice', [
                'id' => $percaseInvoiceTestRecord->id
            ])
            ->assertResponseOk();
    }
}
