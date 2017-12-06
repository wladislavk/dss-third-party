<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\GuideSettingOptionsRetriever;
use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;
use DentalSleepSolutions\Eloquent\Models\Dental\GuideSettingOption;
use Mockery\MockInterface;
use Tests\TestCases\UnitTestCase;

class GuideSettingOptionsRetrieverTest extends UnitTestCase
{
    /**
     * @var GuideSettingOptionsRetriever
     */
    private $guideSettingOptionsRetriever;

    public function setUp()
    {
        $guideSettingOptionRepository = $this->mockGuideSettingOptionRepository();

        $this->guideSettingOptionsRetriever = new GuideSettingOptionsRetriever(
            $guideSettingOptionRepository
        );
    }

    public function testGet()
    {
        $guideSettingOptions = $this->guideSettingOptionsRetriever->get();

        $guideSettingOption1 = new GuideSettingOption();
        $guideSettingOption1->id = 1;
        $guideSettingOption1->labels = ['Label1', 'Label2', 'Label3'];
        $guideSettingOption1->name = 'Test Setting1';
        $guideSettingOption1->setting_type = 0;
        $guideSettingOption1->number = 3;

        $guideSettingOption2 = new GuideSettingOption();
        $guideSettingOption2->id = 2;
        $guideSettingOption2->labels = ['Label1', 'Label2', 'Label3', 'Label4', 'Label5'];
        $guideSettingOption2->name = 'Test Setting2';
        $guideSettingOption2->setting_type = 0;
        $guideSettingOption2->number = 5;

        $expectedSettings = [$guideSettingOption1, $guideSettingOption2];
        $this->assertEquals($expectedSettings, $guideSettingOptions);
    }

    private function mockGuideSettingOptionRepository()
    {
        /** @var GuideSettingOptionRepository|MockInterface $guideSettingOptionRepository */
        $guideSettingOptionRepository = \Mockery::mock(GuideSettingOptionRepository::class);

        $guideSettingOptionRepository->shouldReceive('getOptionsBySettingIds')
            ->andReturnUsing(function () {
                $guideSettingOption1 = new GuideSettingOption();
                $guideSettingOption1->id = 1;
                $guideSettingOption1->labels = 'Label1,Label2,Label3';
                $guideSettingOption1->name = 'Test Setting1';
                $guideSettingOption1->setting_type = 0;
                $guideSettingOption1->number = 3;

                $guideSettingOption2 = new GuideSettingOption();
                $guideSettingOption2->id = 2;
                $guideSettingOption2->labels = 'Label1,Label2,Label3,Label4,Label5';
                $guideSettingOption2->name = 'Test Setting2';
                $guideSettingOption2->setting_type = 0;
                $guideSettingOption2->number = 5;

                return [$guideSettingOption1, $guideSettingOption2];
            })
        ;

        return $guideSettingOptionRepository;
    }
}
