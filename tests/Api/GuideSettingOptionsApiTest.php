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

    public function testGetOptionsForSettingIds()
    {
        $this->post(self::ROUTE_PREFIX . '/guide-setting-options/settingIds');
        $this->assertResponseOk();
        $this->assertEquals(10, count($this->getResponseData()));
        $expectedFirst = [
            'id' => 13,
            'labels' => 'Not Important,Neutral,Very Important',
            'name' => 'Comfort',
            'setting_type' => 0,
            'number' => 3,
        ];
        $this->assertEquals($expectedFirst, $this->getResponseData()[0]);
    }
}
