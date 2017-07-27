<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Diagnostic;
use Tests\TestCases\ApiTestCase;

class DiagnosticsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Diagnostic::class;
    }

    protected function getRoute()
    {
        return '/diagnostics';
    }

    protected function getStoreData()
    {
        return [
            'diagnostic'  => 'test',
            'description' => 'test description',
            'status'      => 10,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated test description',
            'sortby'      => 100,
        ];
    }
}
