<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\GuideSetting;
use Tests\TestCases\ApiTestCase;

class GuideSettingsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return GuideSetting::class;
    }

    protected function getRoute()
    {
        return '/guide-settings';
    }

    protected function getStoreData()
    {
        return [
            'name'         => 'John Doe',
            'setting_type' => 10,
            'range_start'  => 0,
            'range_end'    => 10,
            'rank'         => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name' => 'John Doe II',
            'rank' => 5,
        ];
    }
}
