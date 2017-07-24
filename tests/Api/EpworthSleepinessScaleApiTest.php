<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale;
use Tests\TestCases\ApiTestCase;

class EpworthSleepinessScaleApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return EpworthSleepinessScale::class;
    }

    protected function getRoute()
    {
        return '/epworth-sleepiness-scale';
    }

    protected function getStoreData()
    {
        return [
            'epworth' => 'test situation',
            'status'  => 7,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'sortby' => 10,
            'status' => 5,
        ];
    }
}
