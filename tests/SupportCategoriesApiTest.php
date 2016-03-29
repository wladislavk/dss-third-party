<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\SupportCategory;

class SupportCategoriesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/support-categories -> SupportCategoriesController@store method
     * 
     */
    public function testAddSupportCategory()
    {
        $data = factory(SupportCategory::class)->make()->toArray();

        $data['title'] = 'test support category';

        $this->post('/api/v1/support-categories', $data)
            ->seeInDatabase('dental_support_categories', ['title' => 'test support category'])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/support-categories/{id} -> SupportCategoriesController@update method
     * 
     */
    public function testUpdateSupportCategory()
    {
        $supportCategoryTestRecord = factory(SupportCategory::class)->create();

        $data = ['title' => 'updated support category'];

        $this->put('/api/v1/support-categories/' . $supportCategoryTestRecord->id, $data)
            ->seeInDatabase('dental_support_categories', ['title' => 'updated support category'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/support-categories/{id} -> SupportCategoriesController@destroy method
     * 
     */
    public function testDeleteSupportCategory()
    {
        $supportCategoryTestRecord = factory(SupportCategory::class)->create();

        $this->delete('/api/v1/support-categories/' . $supportCategoryTestRecord->id)
            ->notSeeInDatabase('dental_support_categories', [
                'id' => $supportCategoryTestRecord->id
            ])
            ->assertResponseOk();
    }
}
