<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use Tests\TestCases\ApiTestCase;

class HomeSleepTestsApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return HomeSleepTest::class;
    }

    protected function getRoute()
    {
        return '/home-sleep-tests';
    }

    protected function getStoreData()
    {
        return [
            "doc_id" => 8,
            "user_id" => 100,
            "company_id" => 1,
            "patient_id" => 3,
            "screener_id" => 3,
            "ins_co_id" => 0,
            "ins_phone" => "6868475519",
            "patient_ins_group_id" => "99",
            "patient_ins_id" => "48",
            "patient_firstname" => "Jerry",
            "patient_lastname" => "Lowe",
            "patient_add1" => "92269 Destin Stream\nDinafurt, ME 63582-2745",
            "patient_add2" => "688 Hagenes Lane Apt. 480\nLebsackland, KY 06818",
            "patient_city" => "West Camilatown",
            "patient_state" => "NV",
            "patient_zip" => "52502",
            "patient_dob" => "2000-04-09 00:00:00",
            "patient_cell_phone" => "1286821076",
            "patient_home_phone" => "2191737565",
            "patient_email" => "jraynor@gottlieb.com",
            "diagnosis_id" => 6,
            "hst_type" => 6,
            "provider_firstname" => "Van",
            "provider_lastname" => "Harris",
            "provider_phone" => "0202861358",
            "provider_address" => "227 Cordell Shores Apt. 808\nLake Branson, UT 79945-7218",
            "provider_city" => "Lake Tyreekbury",
            "provider_state" => "MS",
            "provider_zip" => "54150",
            "provider_signature" => "quo",
            "provider_date" => "1974-01-31 00:00:00",
            "snore_1" => 8,
            "snore_2" => 6,
            "snore_3" => 1,
            "snore_4" => 6,
            "snore_5" => 2,
            "viewed" => 7,
            "status" => 2,
            "adddate" => "2004-06-25 15:07:30",
            "office_notes" => "Eveniet doloremque quia ipsam exercitationem consequatur.",
            "sleep_study_id" => 5,
            "authorized_id" => 1,
            "authorizeddate" => "2014-01-14 13:49:44",
            "updatedate" => "1976-11-25 15:36:59",
            "rejected_reason" => "Quia id hic et alias ut odit.",
            "rejecteddate" => "2011-05-13 14:48:26",
            "canceled_id" => 6,
            "canceled_date" => "2016-07-17 18:19:53",
            "hst_nights" => 6,
            "hst_positions" => "Nam minima.",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'office_notes' => 'updated Home Sleep Tests',
            'user_id'      => 7,
        ];
    }

    public function testGetUncompleted()
    {
        $this->post(self::ROUTE_PREFIX . '/home-sleep-tests/uncompleted');
        $this->assertResponseOk();
        $ids = array_column($this->getResponseData(), 'id');
        $expected = [20, 21];
        $this->assertEquals($expected, $ids);
    }

    public function testGetByType()
    {
        $type = 'completed';
        $this->post(self::ROUTE_PREFIX . '/home-sleep-tests/' . $type);
        $this->assertResponseOk();
        $expected = [
            'total' => 0,
        ];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
