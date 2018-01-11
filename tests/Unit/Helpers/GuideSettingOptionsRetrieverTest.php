<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;
use DentalSleepSolutions\Helpers\GuideSettingOptionsRetriever;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class GuideSettingOptionsRetrieverTest extends UnitTestCase
{
    /** @var array[] */
    private $settings = [];

    /** @var GuideSettingOptionsRetriever */
    private $guideSettingOptionsRetriever;

    public function setUp()
    {
        $this->settings = [
            [
                'id' => 1,
                'labels' => 'first,second',
                'name' => 'First setting',
                'number' => 5,
            ],
            [
                'id' => 2,
                'labels' => 'third,fourth',
                'name' => 'Second setting',
                'number' => 15,
            ],
        ];
        $repository = $this->mockGuideSettingOptionRepository();
        $this->guideSettingOptionsRetriever = new GuideSettingOptionsRetriever($repository);
    }

    public function testGetGuideSettingOptions()
    {
        $settingOptions = $this->guideSettingOptionsRetriever->get();
        $settingOptionsArray = [];
        foreach ($settingOptions as $option) {
            $settingOptionsArray[] = $option->toArray();
        }
        $expected = [
            [
                'id' => 1,
                'labels' => ['first', 'second'],
                'name' => 'First setting',
                'number' => 5,
            ],
            [
                'id' => 2,
                'labels' => ['third', 'fourth'],
                'name' => 'Second setting',
                'number' => 15,
            ],
        ];
        $this->assertEquals($expected, $settingOptionsArray);
    }

    private function mockGuideSettingOptionRepository()
    {
        /** @var GuideSettingOptionRepository|MockInterface $guideSettingOptionRepository */
        $guideSettingOptionRepository = \Mockery::mock(GuideSettingOptionRepository::class);
        $guideSettingOptionRepository->shouldReceive('getOptionsBySettingIds')->andReturnUsing(function () {
            return $this->settings;
        });
        return $guideSettingOptionRepository;
    }
}
