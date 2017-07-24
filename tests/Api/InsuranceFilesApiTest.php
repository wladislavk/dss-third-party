<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Dental\InsuranceFile;
use Tests\TestCases\ApiTestCase;

class InsuranceFilesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return InsuranceFile::class;
    }

    protected function getRoute()
    {
        return '/insurance-files';
    }

    protected function getStoreData()
    {
        return [
            "claimid" => 100,
            "claimtype" => "primary",
            "filename" => "DSS_Logo_408022_5707_712931_5490.jpeg",
            "adddate" => "2007-04-13 14:14:00",
            "description" => "Corrupti modi quam sed quisquam molestiae.",
            "status" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'description' => 'updated insurance file',
            'status'      => 8,
        ];
    }
}
