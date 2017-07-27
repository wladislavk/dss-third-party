<?php
namespace Tests\Api;

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
        $this->post('/api/v1/guide-settings/sort');
        $this->assertResponseOk();
        $result = json_decode($this->response->getContent(), true)['data'];
        $names = array_column($result, 'name');
        $sortedNames = Helpers::saneSort($names);
        $this->assertTrue($names === $sortedNames);
        $ids = array_column($result, 'id');
        $sortedIds = Helpers::saneSort($ids);
        $this->assertFalse($ids === $sortedIds);
    }
}
