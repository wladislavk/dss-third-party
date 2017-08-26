<?php

namespace Tests\Unit\Helpers;

use Carbon\Carbon;
use DentalSleepSolutions\Helpers\LetterComposer;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class LetterComposerTest extends UnitTestCase
{
    /** @var LetterData */
    private $letterData;

    /** @var LetterComposer */
    private $letterComposer;

    public function setUp()
    {
        date_default_timezone_set('UTC');

        $this->letterData = new LetterData();

        $this->letterComposer = new LetterComposer();
    }

    public function testComposeLetter()
    {
        $data = $this->letterComposer->composeLetter($this->letterData);
        $expected = [
            'cc_md_list' => null,
            'cc_md_referral_list' => null,
            'cc_pat_referral_list' => null,
            'cc_topatient' => null,
            'date_sent' => '',
            'deleted' => false,
            'deleted_by' => null,
            'deleted_on' => Carbon::now(),
            'delivered' => '0',
            'docid' => null,
            'font_family' => null,
            'font_size' => null,
            'generated_date' => Carbon::now(),
            'info_id' => 0,
            'md_list' => null,
            'md_referral_list' => null,
            'patientid' => 0,
            'pat_referral_list' => null,
            'send_method' => null,
            'status' => null,
            'template' => null,
            'templateid' => null,
            'template_type' => null,
            'topatient' => null,
            'userid' => null,
        ];
        $this->assertEquals($expected, $data);
    }

    public function testComposeLetterWithParentId()
    {
        $this->letterData->parentId = 10;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals(10, $data['parentid']);
    }

    public function testComposeLetterWithStatusTrue()
    {
        $this->letterData->parentId = 10;
        $this->letterData->status = true;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals('', $data['parentid']);
        $this->assertEquals(Carbon::now(), $data['date_sent']);
    }

    public function testComposeLetterWithTemplate()
    {
        $this->letterData->template = '&lt;a&gt;&nbsp;b&nbsp;c';
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals('<a>bc', $data['template']);
    }

    public function testComposeLetterWithToPatient()
    {
        $this->letterData->toPatient = 1;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals(1, $data['cc_topatient']);
    }

    public function testComposeLetterWithMdList()
    {
        $this->letterData->mdList = 1;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals(1, $data['cc_md_list']);
    }

    public function testComposeLetterWithMdReferralList()
    {
        $this->letterData->mdReferralList = 1;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals(1, $data['cc_md_referral_list']);
    }

    public function testComposeLetterWithPatientReferralList()
    {
        $this->letterData->patientReferralList = 1;
        $data = $this->letterComposer->composeLetter($this->letterData);
        $this->assertEquals(1, $data['cc_pat_referral_list']);
    }

    public function testComposeWelcomeLetter()
    {
        $docId = 1;
        $templateId = 2;
        $mdList = 0;
        $data = $this->letterComposer->composeWelcomeLetter($docId, $templateId, $mdList);
        $expected = [
            'templateid' => 2,
            'generated_date' => Carbon::now(),
            'delivered' => '0',
            'status' => '0',
            'deleted' => '0',
            'docid' => 1,
            'userid' => 1,
        ];
        $this->assertEquals($expected, $data);
    }

    public function testComposeWelcomeLetterWithMdList()
    {
        $docId = 1;
        $templateId = 2;
        $mdList = 3;
        $data = $this->letterComposer->composeWelcomeLetter($docId, $templateId, $mdList);
        $expected = [
            'templateid' => 2,
            'generated_date' => Carbon::now(),
            'delivered' => '0',
            'status' => '0',
            'deleted' => '0',
            'docid' => 1,
            'userid' => 1,
            'md_list' => 3,
            'cc_md_list' => 3,
        ];
        $this->assertEquals($expected, $data);
    }
}
