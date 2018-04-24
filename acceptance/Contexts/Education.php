<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
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
     * @Then I see videos education page
     */
    public function testVideos()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $headings = $this->findAllCss('h2');
        Assert::assertGreaterThan(0, sizeof($headings));
        Assert::assertEquals('Fundamentals of Dental Sleep Medicine', $headings[0]->getText());
    }

    /**
     * @Then I see certificates education page
     */
    public function testCertificates()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $heading = $this->findCss('#contentMain');
        Assert::assertNotNull($heading);
        Assert::assertContains('EdX Certificates', $this->sanitizeText($heading->getText()));
    }

    /**
     * @Then I see the list of certificates:
     *
     * @param TableNode $table
     */
    public function testCertificatesList(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'name');
        $list = $this->findAllCss('ul.fullwidth li');
        Assert::assertEquals(sizeof($expected), sizeof($list));
        foreach ($expected as $key => $element) {
            Assert::assertEquals($element, $this->sanitizeText($list[$key]->getText()));
        }
    }
}
