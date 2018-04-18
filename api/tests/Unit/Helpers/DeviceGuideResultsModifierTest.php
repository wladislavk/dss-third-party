<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\DeviceGuideResultsModifier;
use DentalSleepSolutions\Structs\DeviceInfo;
use Tests\TestCases\UnitTestCase;

class DeviceGuideResultsModifierTest extends UnitTestCase
{
    /** @var DeviceGuideResultsModifier */
    private $deviceGuideResultsModifier;

    public function setUp()
    {
        $this->deviceGuideResultsModifier = new DeviceGuideResultsModifier();
    }

    public function testModifyResult()
    {
        $firstDevice = new DeviceInfo();
        $firstDevice->id = 1;
        $firstDevice->name = 'first';
        $firstDevice->isHidden = false;
        $firstDevice->value = 10.0;
        $firstDevice->imagePath = 'first.jpg';
        $secondDevice = new DeviceInfo();
        $secondDevice->id = 2;
        $secondDevice->name = 'second';
        $secondDevice->isHidden = true;
        $secondDevice->value = 20.0;
        $secondDevice->imagePath = 'second.jpg';
        $thirdDevice = new DeviceInfo();
        $thirdDevice->id = 3;
        $thirdDevice->name = 'third';
        $thirdDevice->isHidden = false;
        $thirdDevice->value = 30.5;
        $thirdDevice->imagePath = 'third.jpg';
        $devices = [$firstDevice, $secondDevice, $thirdDevice];
        $result = $this->deviceGuideResultsModifier->modifyResult($devices);
        $expected = [
            [
                'id' => 3,
                'name' => 'third',
                'value' => 30.5,
                'image_path' => 'third.jpg',
            ],
            [
                'id' => 1,
                'name' => 'first',
                'value' => 10.0,
                'image_path' => 'first.jpg',
            ],
        ];
        $this->assertEquals($expected, $result);
    }
}
