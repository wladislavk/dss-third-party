<?php

namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\EdxCertificate;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
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

    public function testGetByUser()
    {
        /** @var User $user */
        $user = User::find(1);
        $this->be($user);
        $this->get(self::ROUTE_PREFIX . '/edx-certificates/by-user');
        $this->assertResponseOk();
        $response = $this->getResponseData();
        $this->assertEquals(7, sizeof($response));
        $expectedFirst = [
            'id' => 1,
            'url' => 'http://preprod.edx.dss.xforty.com/courses/x40/Course001/Now/3/retrieve_cert',
            'edx_id' => 3,
            'course_name' => 'Course001',
            'course_section' => 'Now',
            'course_subsection' => 'Section 1',
            'number_ce' => 1,
            'adddate' => '2014-03-17 22:15:41',
            'ip_address' => '10.20.1.168',
        ];
        $this->assertEquals($expectedFirst, $response[0]);
    }
}
