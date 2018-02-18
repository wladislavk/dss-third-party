<?php
namespace Tests\Api;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use Tests\TestCases\ApiTestCase;

class LettersApiTest extends ApiTestCase
{
    protected function getModel()
    {
        return Letter::class;
    }

    protected function getRoute()
    {
        return '/letters';
    }

    protected function getStoreData()
    {
        return [
            "patientid" => 100,
            "stepid" => 7,
            "delivery_date" => "2007-10-02 09:28:28",
            "send_method" => "vel",
            "template" => "Dolorum iure sunt quidem hic.",
            "pdf_path" => "facere",
            "status" => 6,
            "delivered" => 2,
            "deleted" => 0,
            "templateid" => 9,
            "parentid" => 3,
            "topatient" => 0,
            "md_list" => "perferendis",
            "md_referral_list" => "odio",
            "docid" => 2,
            "userid" => 3,
            "date_sent" => "1996-07-08 02:40:46",
            "info_id" => 3,
            "edit_userid" => 8,
            "mailed_date" => "1982-12-28 00:35:39",
            "mailed_once" => 2,
            "template_type" => 2,
            "cc_topatient" => 5,
            "cc_md_list" => "maxime",
            "cc_md_referral_list" => "voluptatum",
            "font_family" => "earum",
            "font_size" => 1,
            "pat_referral_list" => "consequuntur",
            "cc_pat_referral_list" => "placeat",
            "deleted_by" => 2,
            "deleted_on" => "1983-07-30 05:12:20",
        ];
    }

    protected function getUpdateData()
    {
        return [
            'patientid'   => 33,
            'send_method' => 'email',
            'status'      => 0,
            'templateid'  => 12,
        ];
    }

    public function testGetContactSentLetters()
    {
        $this->post(self::ROUTE_PREFIX . '/letters/delivered-for-contact');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetContactPendingLetters()
    {
        $this->post(self::ROUTE_PREFIX . '/letters/not-delivered-for-contact');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testCreateWelcomeLetter()
    {
        $this->post(self::ROUTE_PREFIX . '/letters/create-welcome-letter');
        $this->assertResponseOk();
        $this->assertEquals([], $this->getResponseData());
    }

    public function testGetGeneratedDateOfIntroLetter()
    {
        $this->post(self::ROUTE_PREFIX . '/letters/gen-date-of-intro');
        $this->assertResponseOk();
        $this->assertNull($this->getResponseData());
    }

    public function testGetByPatientAndInfo()
    {
        $patientId = 170;
        $infoIds = [579, 553, 552];
        $url = '/letters/by-patient-and-info?patient_id=' . $patientId;
        foreach ($infoIds as $key => $id) {
            $url .= '&info_ids[' . $key . ']=' . $id;
        }
        $this->get(self::ROUTE_PREFIX . $url);
        $this->assertResponseOk();
        $expected = [];
        $this->assertEquals($expected, $this->getResponseData());
    }
}
