<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Filemanager;
use Tests\TestCases\ApiTestCase;

class FilemanagerApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Filemanager::class;
    }

    protected function getRoute()
    {
        return '/filemanager';
    }

    protected function getStoreData()
    {
        return [
            "docid" => 100,
            "name" => "4pUxV_QZVp_amx7.bmp",
            "type" => "image/gif",
            "size" => 8,
            "ext" => "jpeg",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'  => 'Update_Name.jpg',
            'docid' => 7,
        ];
    }
}
