<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Staff extends BaseContext
{
    /**
     * @Then I see the staff list:
     *
     * @param TableNode $table
     */
    public function testStaffList(TableNode $table)
    {
        $form = $this->findCss('form[name="sortfrm"]');
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 2;
            $usernameColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(1)", $form);
            $nameColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(2)", $form);
            $producerColumn = $this->findCss("tbody > tr:nth-child($childNumber) > td:nth-child(3)", $form);
            $tr = $this->findCss("tbody > tr:nth-child($childNumber)", $form);
            Assert::assertEquals($row['username'], $this->sanitizeText($usernameColumn->getText()));
            Assert::assertEquals($row['name'], $this->sanitizeText($nameColumn->getText()));
            $trClass = 'tr_active';
            if ($row['grey'] == 'yes') {
                $trClass = 'tr_inactive';
            }
            Assert::assertEquals($trClass, $tr->getAttribute('class'));
            $producer = '';
            if ($row['producer'] == 'yes') {
                $producer = 'X';
            }
            Assert::assertEquals($producer, $this->sanitizeText($producerColumn->getText()));
        }
    }

    /**
     * @Then I see add staff form:
     *
     * @param TableNode $table
     */
    public function testAddStaffForm(TableNode $table)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $form = $this->findCss('form[name="stafffrm"]');
        $expectedRows = $table->getHash();
        $tableRows = $this->findAllCss("tbody > tr", $form);
        $newTableRows = [];
        foreach ($tableRows as $tableRow) {
            if ($tableRow->isVisible()) {
                $newTableRows[] = $tableRow;
            }
        }
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 1;
            $nameColumn = $this->findCss("td:nth-child(1)", $newTableRows[$childNumber]);
            $valueColumn = $this->findCss("td:nth-child(2)", $newTableRows[$childNumber]);
            Assert::assertEquals($row['field'], $this->sanitizeText($nameColumn->getText()));
            Assert::assertTrue($this->checkRequiredFormElement($valueColumn, $row['required']));
            Assert::assertTrue($this->checkFormElement($valueColumn, $row['type']));
        }

        $this->getCommonClient()->switchToIFrame();
    }
}
