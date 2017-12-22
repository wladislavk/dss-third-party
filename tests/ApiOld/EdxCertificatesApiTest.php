<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\EdxCertificate;
use Tests\TestCases\ApiTestCase;

class EdxCertificatesApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return EdxCertificate::class;
    }

    protected function getRoute()
    {
        return '/edx-certificates';
    }

    protected function getStoreData()
    {
        return [
            "url" => "http://roberts.biz/",
            "edx_id" => 9,
            "course_name" => "Tenetur ad facilis eveniet.",
            "course_section" => "Voluptas qui laborum laborum.",
            "course_subsection" => "Omnis non.",
            "number_ce" => 8,
        ];
    }

    protected function getUpdateData()
    {
        return [
            'course_name' => 'updated course name',
            'number_ce'   => 9,
        ];
    }
}
