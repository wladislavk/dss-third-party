<?php
namespace Tests\ApiOld;

use DentalSleepSolutions\Eloquent\Models\Dental\CustomLetterTemplate;
use Tests\TestCases\ApiTestCase;

class CustomLetterTemplatesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return CustomLetterTemplate::class;
    }

    protected function getRoute()
    {
        return '/custom-letter-templates';
    }

    protected function getStoreData()
    {
        return [
            "name" => "Perspiciatis omnis reprehenderit voluptas.",
            "body" => "Aut alias temporibus voluptatem minima sit.",
            "docid" => 100,
            "adddate" => "2012-08-26 11:06:22",
            "status" => 1,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'name'   => 'updated name',
            'status' => 8,
        ];
    }
}
