<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\ImageType;
use Tests\TestCases\ApiTestCase;

class ImageTypesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return ImageType::class;
    }

    protected function getRoute()
    {
        return '/image-types';
    }

    protected function getStoreData()
    {
        return [
            "imagetype" => "nihil",
            "description" => "At impedit sunt magni.",
            "sortby" => 100,
            "status" => 9,
            "adddate" => "1984-07-19 15:51:30",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated image type',
            'status'      => 8,
        ];
    }
}
