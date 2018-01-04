<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\GuideSettingOptionsRetriever;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use DentalSleepSolutions\Structs\GuideSettingOption as GuideSettingOptionStruct;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class GuideSettingOptionsRetrieverTest extends UnitTestCase
{
    /** @var GuideSettingOption[] */
    private $options = [];

    /**
     * @var GuideSettingOptionsRetriever
     */
    private $guideSettingOptionsRetriever;

    public function setUp()
    {
        $guideSettingOption1 = new GuideSettingOption();
        $guideSettingOption1->id = 1;
        $guideSettingOption1->labels = 'Label1,Label2,Label3';
        $guideSettingOption1->name = 'Test Setting1';
        $guideSettingOption1->settingType = 0;
        $guideSettingOption1->number = 3;

        $guideSettingOption2 = new GuideSettingOption();
        $guideSettingOption2->id = 2;
        $guideSettingOption2->labels = 'Label1,Label2,Label3,Label4,Label5';
        $guideSettingOption2->name = 'Test Setting2';
        $guideSettingOption2->settingType = 0;
        $guideSettingOption2->number = 5;

        $this->options = [$guideSettingOption1, $guideSettingOption2];

        $guideSettingOptionRepository = $this->mockGuideSettingOptionRepository();
        $this->guideSettingOptionsRetriever = new GuideSettingOptionsRetriever(
            $guideSettingOptionRepository
        );
    }

    public function testGet()
    {
        $guideSettingOptions = $this->guideSettingOptionsRetriever->get();

        $this->assertEquals(2, sizeof($guideSettingOptions));
        $firstOption = $guideSettingOptions[0];
        $this->assertEquals(1, $firstOption->id);
        $this->assertEquals(['Label1', 'Label2', 'Label3'], $firstOption->labels);
        $this->assertEquals('Test Setting1', $firstOption->name);
        $this->assertEquals(0, $firstOption->settingType);
        $this->assertEquals(3, $firstOption->number);
    }

    private function mockGuideSettingOptionRepository()
    {
        /** @var GuideSettingOptionRepository|MockInterface $guideSettingOptionRepository */
        $guideSettingOptionRepository = \Mockery::mock(GuideSettingOptionRepository::class);

        $guideSettingOptionRepository->shouldReceive('getOptionsBySettingIds')->andReturnUsing(function () {
            return $this->options;
        });
        return $guideSettingOptionRepository;
    }
}
