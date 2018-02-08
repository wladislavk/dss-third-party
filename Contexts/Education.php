<?php

namespace Contexts;

use PHPUnit\Framework\Assert;

class Education extends BaseContext
{

    /**
     * @Then I see dental sleep procedures manual
     */
    public function testProceduresManual()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('h2');
        Assert::assertNotNull($heading);
        Assert::assertEquals('DENTAL SLEEP PROCEDURES MANUAL', $this->sanitizeText($heading->getText()));
    }

    /**
     * @Then I see dental sleep medicine manual
     */
    public function testMedicineManual()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('.WordSection1 b');
        Assert::assertNotNull($heading);
        Assert::assertEquals('DENTAL SLEEP MEDICINE', $this->sanitizeText($heading->getText()));
    }

    /**
     * @Then I see quick facts reference
     */
    public function testQuickFactsReference()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('.MsoNormal');
        Assert::assertNotNull($heading);
        Assert::assertEquals('QUICK FACTS & REFERENCE', $this->sanitizeText($heading->getText()));
    }

    /**
     * @Then I see videos
     */
    public function testVideos()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('h2:nth-child(2)');
        Assert::assertNotNull($heading);
        Assert::assertEquals('Fundamentals of Dental Sleep Medicine', $this->sanitizeText($heading->getText()));
    }

    /**
     * @Then I see certificates
     */
    public function testCertificates()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('#contentMain');
        Assert::assertNotNull($heading);
        Assert::assertEquals('EdX Certificates', $this->sanitizeText($heading->getText()));
    }
}
