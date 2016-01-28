<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\InsuranceDocument;

class InsuranceDocumentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/insurance-documents -> InsuranceDocumentsController@store method
     * 
     */
    public function testAddInsuranceDocument()
    {
        $data = [
            'title'       => 'test',
            'description' => 'test description',
            'status'      => 7
        ];

        $this->post('/api/v1/insurance-documents', $data)
            ->seeInDatabase('dental_doc_insurance', ['description' => 'test description'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/insurance-documents/{id} -> InsuranceDocumentsController@update method
     * 
     */
    public function testUpdateInsuranceDocument()
    {
        $insuranceDocumentTestRecord = factory(InsuranceDocument::class)->create();

        $data = [
            'description' => 'updated test description'
        ];

        $this->put('/api/v1/insurance-documents/' . $insuranceDocumentTestRecord->doc_insuranceid, $data)
            ->seeInDatabase('dental_doc_insurance', ['description' => 'updated test description'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/insurance-documents/{id} -> InsuranceDocumentsController@destroy method
     * 
     */
    public function testDeleteInsuranceDocument()
    {
        $insuranceDocumentTestRecord = factory(InsuranceDocument::class)->create();

        $this->delete('/api/v1/insurance-documents/' . $insuranceDocumentTestRecord->doc_insuranceid)
            ->notSeeInDatabase('dental_doc_insurance', ['doc_insuranceid' => $insuranceDocumentTestRecord->doc_insuranceid])
            ->assertResponseOk();
    }
}
