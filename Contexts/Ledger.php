<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Ledger extends BaseContext
{
    /**
     * @When I select :code as procedure code
     *
     * @param string $code
     */
    public function selectProcedureCode($code)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $select = $this->findCss('select#procedure_code1');
        $options = $this->findAllCss('option', $select);
        foreach ($options as $option) {
            if ($option->getText() == $code) {
                $select->selectOption($option->getText());
            }
        }

        $this->getCommonClient()->switchToIFrame();
    }

    /**
     * @Then I see ledger card for :username
     *
     * @param string $username
     */
    public function testLedgerCardForUser($username)
    {
        $content = $this->findCss('div#contentMain');
        $heading = $this->findCss('span.admin_head', $content);
        Assert::assertEquals('Ledger Card', $this->sanitizeText($heading->getText()));
        Assert::assertContains($username, $content->getText());
    }

    /**
     * @Then I see ledger table with :numberOfRecords records
     *
     * @param string $numberOfRecords
     */
    public function testNumberOfRecordsInLedgerTable($numberOfRecords)
    {
        $table = $this->findCss('table.ledger');
        Assert::assertNotNull($table);
        $rows = $this->findAllCss('tbody > tr', $table);
        $expectedNumber = intval($numberOfRecords) + 4;
        $realNumber = 0;
        foreach ($rows as $row) {
            if ($row->isVisible()) {
                $realNumber++;
            }
        }
        Assert::assertEquals($expectedNumber, $realNumber);
    }

    /**
     * @Then total ledger data is as follows:
     *
     * @param TableNode $table
     */
    public function testTotalLedgerData(TableNode $table)
    {
        $expectedRow = $table->getHash()[0];
        $headingRows = $this->findAllCss('table.ledger > tbody > tr.tr_bg_h');
        Assert::assertArrayHasKey(2, $headingRows);
        $totalsRow = $headingRows[2];
        $charges = $this->findCss('td:nth-child(5)', $totalsRow);
        Assert::assertEquals($expectedRow['charges'], $charges->getText());
        $credits = $this->findCss('td:nth-child(6)', $totalsRow);
        Assert::assertEquals($expectedRow['credits'], $credits->getText());
        $adjustments = $this->findCss('td:nth-child(7)', $totalsRow);
        Assert::assertEquals($expectedRow['adjustments'], $adjustments->getText());
        $balance = $this->findCss('td:nth-child(8)', $totalsRow);
        Assert::assertEquals($expectedRow['balance'], $balance->getText());
    }

    /**
     * @Then I see add transaction form with following fields:
     *
     * @param TableNode $table
     */
    public function testAddTransactionForm(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $firstRow = $this->findCss('div#form_div > div:first-child');
        $spans = $this->findAllCss('span', $firstRow);
        $divs = $this->findAllCss('div', $firstRow);
        $expectedFields = array_column($table->getHash(), 'field');
        foreach ($expectedFields as $expectedField) {
            $fieldExists = false;
            foreach ($spans as $span) {
                if ($span->getText() == $expectedField) {
                    $fieldExists = true;
                }
            }
            foreach ($divs as $div) {
                if ($div->getText() == $expectedField) {
                    $fieldExists = true;
                }
            }
            Assert::assertTrue($fieldExists);
        }
        // @todo: impossible to check types correctly with present html

        $this->getCommonClient()->switchToIFrame();
    }

    /**
     * @Then I see page with heading :heading and today's date
     *
     * @param string $heading
     */
    public function testLedgerReportHeading($heading)
    {
        $realHeading = $this->findCss('span.admin_head');
        Assert::assertContains($heading, $realHeading->getText());
        $date = (new \DateTime())->format('m/d/Y');
        Assert::assertContains("($date)", $realHeading->getText());
    }

    /**
     * @Then I see these ledger totals sections:
     *
     * @param TableNode $table
     */
    public function testLedgerTotalsSections(TableNode $table)
    {
        $expectedNames = array_column($table->getHash(), 'name');
        $expectedSums = array_column($table->getHash(), 'total');
        $names = $this->findAllCss('div.fullwidth h3');
        foreach ($expectedNames as $key => $name) {
            Assert::assertEquals($name, $names[$key]->getText());
        }
        $totals = $this->findAllCss('div.fullwidth > ul');
        foreach ($expectedSums as $key => $sum) {
            Assert::assertContains($sum, $totals[$key]->getText());
        }
    }
}
