<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use Tests\TestCases\ApiTestCase;

class GuideSettingOptionsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return GuideSettingOption::class;
    }

    protected function getRoute()
    {
        return '/guide-setting-options';
    }

    protected function getStoreData()
    {
        return [
            'option_id'  => 10,
            'setting_id' => 10,
            'label'      => 'test',
        ];
    }

    protected function getUpdateData()
    {
        return [
            'label' => 'updated test',
        ];
    }
}
