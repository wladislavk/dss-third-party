<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\ImageType;

class ImageTypesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/image-types -> ImageTypesController@store method
     * 
     */
    public function testAddImageType()
    {
        $data = factory(ImageType::class)->make()->toArray();

        $data['sortby'] = 100;

        $this->post('/api/v1/image-types', $data)
            ->seeInDatabase('dental_imagetype', ['sortby' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/image-types/{id} -> ImageTypesController@update method
     * 
     */
    public function testUpdateImageType()
    {
        $imageTypeTestRecord = factory(ImageType::class)->create();

        $data = [
            'description' => 'updated image type',
            'status'      => 8
        ];

        $this->put('/api/v1/image-types/' . $imageTypeTestRecord->imagetypeid, $data)
            ->seeInDatabase('dental_imagetype', ['description' => 'updated image type'])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/image-types/{id} -> ImageTypesController@destroy method
     * 
     */
    public function testDeleteImageType()
    {
        $imageTypeTestRecord = factory(ImageType::class)->create();

        $this->delete('/api/v1/image-types/' . $imageTypeTestRecord->imagetypeid)
            ->notSeeInDatabase('dental_imagetype', [
                'imagetypeid' => $imageTypeTestRecord->imagetypeid
            ])
            ->assertResponseOk();
    }
}
