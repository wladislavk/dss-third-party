<?php
namespace Tests\Api;

use Tests\TestCases\ApiTestCase;
use DentalSleepSolutions\Eloquent\Dental\Complaint;

class ComplaintsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Complaint::class;
    }

    protected function getRoute()
    {
        return '/complaints';
    }

    protected function getStoreData()
    {
        return [
            'complaint' => 'Test complaint',
            'sortby'    => 5,
            'status'    => 5,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'complaint' => 'Updated test complaint',
            'status'    => 0,
        ];
    }
}
