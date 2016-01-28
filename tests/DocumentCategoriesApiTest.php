<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\DocumentCategory;

class DocumentCategoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/document-categories -> DocumentCategoriesController@store method
     * 
     */
    public function testAddDocumentCategory()
    {
        $data = [
            'name'   => 'John Doe',
            'status' => 5
        ];

        $this->post('/api/v1/document-categories', $data)
            ->seeInDatabase('dental_document_category', ['name' => 'John Doe'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/document-categories/{id} -> DocumentCategoriesController@update method
     * 
     */
    public function testUpdateDocumentCategory()
    {
        $documentCategoryTestRecord = factory(DocumentCategory::class)->create();

        $data = [
            'status' => 7
        ];

        $this->put('/api/v1/document-categories/' . $documentCategoryTestRecord->categoryid, $data)
            ->seeInDatabase('dental_document_category', ['status' => 7])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/document-categories/{id} -> DocumentCategoriesController@destroy method
     * 
     */
    public function testDeleteDocumentCategory()
    {
        $documentCategoryTestRecord = factory(DocumentCategory::class)->create();

        $this->delete('/api/v1/document-categories/' . $documentCategoryTestRecord->categoryid)
            ->notSeeInDatabase('dental_document_category', [
                'categoryid' => $documentCategoryTestRecord->categoryid
            ])
            ->assertResponseOk();
    }
}
