<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\AppointmentType;
use Tests\TestCases\ApiTestCase;

class AppointmentTypesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return AppointmentType::class;
    }

    protected function getRoute()
    {
        return '/appt-types';
    }

    protected function getStoreData()
    {
        return [
            'name'      => 'testName',
            'color'     => 'FFFFFF',
            'classname' => 'testClassName',
            'docid'     => 12,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'  => 'testUpdatedName',
            'color' => 'FFCCFF',
        ];
    }
}
