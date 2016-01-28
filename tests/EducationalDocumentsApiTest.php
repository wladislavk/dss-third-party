<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\EducationalDocument;

class EducationalDocumentsApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/educational-documents -> EducationalDocumentsController@store method
     * 
     */
    public function testAddEducationalDocument()
    {
        $data = [
            'title'       => 'test',
            'description' => 'test description',
            'video_file'  => 'video.flv'
        ];

        $this->post('/api/v1/educational-documents', $data)
            ->seeInDatabase('dental_doc_educational', ['title' => 'test'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/educational-documents/{id} -> EducationalDocumentsController@update method
     * 
     */
    public function testUpdateEducationalDocument()
    {
        $educationalDocumentTestRecord = factory(EducationalDocument::class)->create();

        $data = [
            'description' => 'updated test description'
        ];

        $this->put('/api/v1/educational-documents/' . $educationalDocumentTestRecord->doc_educationalid, $data)
            ->seeInDatabase('dental_doc_educational', ['description' => 'updated test description'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/educational-documents/{id} -> EducationalDocumentsController@destroy method
     * 
     */
    public function testDeleteEducationalDocument()
    {
        $educationalDocumentTestRecord = factory(EducationalDocument::class)->create();

        $this->delete('/api/v1/educational-documents/' . $educationalDocumentTestRecord->doc_educationalid)
            ->notSeeInDatabase('dental_doc_educational', [
                'doc_educationalid' => $educationalDocumentTestRecord->doc_educationalid
            ])
            ->assertResponseOk();
    }
}
