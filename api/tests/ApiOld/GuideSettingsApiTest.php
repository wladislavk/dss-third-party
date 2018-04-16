<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\GuideSetting;
use DentalSleepSolutions\StaticClasses\Helpers;
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

    public function testGetAllOrderBy()
    {
        $this->post(self::ROUTE_PREFIX . '/guide-settings/sort');
        $this->assertResponseOk();
        $names = array_column($this->getResponseData(), 'name');
        $sortedNames = Helpers::saneSort($names);
        $this->assertTrue($names === $sortedNames);
        $ids = array_column($this->getResponseData(), 'id');
        $sortedIds = Helpers::saneSort($ids);
        $this->assertFalse($ids === $sortedIds);
    }
}
