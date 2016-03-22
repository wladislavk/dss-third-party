<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\Document;

class DocumentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/documents -> DocumentsController@store method
     * 
     */
    public function testAddDocument()
    {
        $data = [
            'categoryid' => 10,
            'name'       => 'test',
            'filename'   => 'test.jpg'
        ];

        $this->post('/api/v1/documents', $data)
            ->seeInDatabase('dental_document', ['categoryid' => 10])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/documents/{id} -> DocumentsController@update method
     * 
     */
    public function testUpdateDocument()
    {
        $documentTestRecord = factory(Document::class)->create();

        $data = [
            'categoryid' => 15
        ];

        $this->put('/api/v1/documents/' . $documentTestRecord->documentid, $data)
            ->seeInDatabase('dental_document', ['categoryid' => 15])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/documents/{id} -> DocumentsController@destroy method
     * 
     */
    public function testDeleteDocument()
    {
        $documentTestRecord = factory(Document::class)->create();

        $this->delete('/api/v1/documents/' . $documentTestRecord->documentid)
            ->notSeeInDatabase('dental_document', ['documentid' => $documentTestRecord->documentid])
            ->assertResponseOk();
    }
}
