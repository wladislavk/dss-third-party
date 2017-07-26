<?php

namespace Tests\Unit\Helpers;

use DentalSleepSolutions\Helpers\LetterCreationEvaluator;
use DentalSleepSolutions\Structs\LetterData;
use Tests\TestCases\UnitTestCase;

class LetterCreationEvaluatorTest extends UnitTestCase
{
    const NORMAL_TEMPLATE_ID = 10;
    const EXCLUDED_TEMPLATE_ID = 16;

    /** @var LetterData */
    private $letterData;

    /** @var int */
    private $templateId;

    /** @var LetterCreationEvaluator */
    private $letterCreationEvaluator;

    public function setUp()
    {
        $this->templateId = self::EXCLUDED_TEMPLATE_ID;
        $this->letterData = new LetterData();
        $this->letterData->toPatient = false;
        $this->letterData->mdReferralList = '';
        $this->letterData->mdList = '';
        $this->letterData->patientReferralList = 'foo';
        $this->letterData->checkRecipient = true;

        $this->letterCreationEvaluator = new LetterCreationEvaluator();
    }

    public function testShouldNotBeCreated()
    {
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertFalse($shouldBeCreated);
    }

    public function testWithToPatient()
    {
        $this->letterData->toPatient = true;
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertTrue($shouldBeCreated);
    }

    public function testWithMdReferralList()
    {
        $this->letterData->mdReferralList = 'foo';
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertTrue($shouldBeCreated);
    }

    public function testWithMdList()
    {
        $this->letterData->mdList = 'foo';
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertTrue($shouldBeCreated);
    }

    public function testWithoutRecipient()
    {
        $this->letterData->checkRecipient = false;
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertTrue($shouldBeCreated);
    }

    public function testWithoutRecipientButWithoutPatientReferral()
    {
        $this->letterData->patientReferralList = '';
        $this->letterData->checkRecipient = false;
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertFalse($shouldBeCreated);
    }

    public function testWithNormalTemplate()
    {
        $this->templateId = self::NORMAL_TEMPLATE_ID;
        $shouldBeCreated = $this->letterCreationEvaluator->shouldLetterBeCreated(
            $this->letterData, $this->templateId
        );
        $this->assertTrue($shouldBeCreated);
    }
}
