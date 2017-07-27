<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use Tests\TestCases\ApiTestCase;

class ProfileImagesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ProfileImage::class;
    }

    protected function getRoute()
    {
        return '/profile-images';
    }

    protected function getStoreData()
    {
        return [
            "formid" => 9,
            "patientid" => 100,
            "title" => "adipisci",
            "image_file" => "le78EsJ8e2RJyW4.png",
            "imagetypeid" => 5,
            "userid" => 2,
            "docid" => 5,
            "status" => 0,
            "adminid" => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'formid'    => 133,
            'patientid' => 85,
            'title'     => 'updated profile image',
        ];
    }
}
