<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class PatientScreener extends BaseContext
{
    const RISK_LEVEL_COLORS = [
        'red' => 'risk_severe',
        'green' => 'risk_low',
        'yellow' => 'risk_moderate',
    ];

    /**
     * @When I click on view results link for patient number :patientNumber in patient screeners list
     *
     * @param string $patientNumber
     */
    public function clickViewResultsLink($patientNumber)
    {
        $childNumber = (intval($patientNumber) * 2) + 1;
        $columnNumber = 7;
        $form = $this->findCss('form[name="sortfrm"]');
        $link = $this->findCss("table > tbody > tr:nth-child($childNumber) > td:nth-child($columnNumber) > a", $form);
        $link->click();
    }

    /**
     * @Then patient screeners list shows not contacted patients only
     *
     * @throws BehatException
     */
    public function testShowNotContactedPatients()
    {
        Assert::assertNotNull($this->findElementWithText('p', 'Showing NOT contacted patients only'));
    }

    /**
     * @Then patient screeners list has following columns:
     *
     * @param TableNode $table
     */
    public function testColumns(TableNode $table)
    {
        $expectedColumns = array_column($table->getHash(), 'name');
        $form = $this->findCss('form[name="sortfrm"]');
        $columns = $this->findAllCss('table > tbody > tr:nth-child(2) > td', $form);
        foreach ($expectedColumns as $key => $expectedColumn) {
            $columnText = $this->sanitizeText($columns[$key]->getText());
            Assert::assertEquals($expectedColumn, $columnText);
        }
    }

    /**
     * @Then I see patient screener data for patient number :patientNumber with sections:
     *
     * @param string $patientNumber
     * @param TableNode $table
     */
    public function testScreenerResultData($patientNumber, TableNode $table)
    {
        $childNumber = (intval($patientNumber) * 2) + 2;
        $form = $this->findCss('form[name="sortfrm"]');
        $row = $this->findCss("table > tbody > tr:nth-child($childNumber)", $form);
        $expectedHeaders = array_column($table->getHash(), 'name');
        foreach ($expectedHeaders as $header) {
            Assert::assertContains("<strong>$header</strong>", $row->getHtml());
        }
    }

    /**
     * @Then patient screener list has following risk levels:
     *
     * @param TableNode $table
     */
    public function testRiskLevels(TableNode $table)
    {
        $rows = $table->getHash();
        $columnNumber = 4;
        foreach ($rows as $row) {
            $childNumber = ($row['patient'] * 2) + 1;
            $form = $this->findCss('form[name="sortfrm"]');
            $td = $this->findCss("table > tbody > tr:nth-child($childNumber) > td:nth-child($columnNumber)", $form);
            Assert::assertEquals($row['risk'], $this->sanitizeText($td->getText()));
            Assert::assertContains(self::RISK_LEVEL_COLORS[$row['color']], $td->getAttribute('class'));
        }
    }
}
