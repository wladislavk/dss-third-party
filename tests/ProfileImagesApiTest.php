<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use DentalSleepSolutions\Eloquent\Dental\ProfileImage;

class ProfileImagesApiTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /**
     * Test the post method of the Dental Sleep Solutions API
     * Post to /api/v1/profile-images -> ProfileImagesController@store method
     * 
     */
    public function testAddProfileImage()
    {
        $data = factory(ProfileImage::class)->make()->toArray();

        $data['patientid'] = 100;

        $this->post('/api/v1/profile-images', $data)
            ->seeInDatabase('dental_q_image', ['patientid' => 100])
            ->assertResponseOk();
    }

    /**
     * Test the put method of the Dental Sleep Solutions API
     * Put to /api/v1/profile-images/{id} -> ProfileImagesController@update method
     * 
     */
    public function testUpdateProfileImage()
    {
        $profileImageTestRecord = factory(ProfileImage::class)->create();

        $data = [
            'formid'    => 133,
            'patientid' => 85,
            'title'     => 'updated profile image'
        ];

        $this->put('/api/v1/profile-images/' . $profileImageTestRecord->imageid, $data)
            ->seeInDatabase('dental_q_image', ['patientid' => 85])
            ->assertResponseOk();
    }

    /**
     * Test the delete method of the Dental Sleep Solutions API
     * Delete to /api/v1/profile-images/{id} -> ProfileImagesController@destroy method
     * 
     */
    public function testDeleteProfileImage()
    {
        $profileImageTestRecord = factory(ProfileImage::class)->create();

        $this->delete('/api/v1/profile-images/' . $profileImageTestRecord->imageid)
            ->notSeeInDatabase('dental_q_image', [
                'imageid' => $profileImageTestRecord->imageid
            ])
            ->assertResponseOk();
    }
}
