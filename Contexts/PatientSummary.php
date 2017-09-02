<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class PatientSummary extends BaseContext
{
    // @todo: DOM should be rewritten and this constant dropped
    const LETTER_TABLES = [
        'Pending Letters' => 0,
        'Sent Letters' => 1,
    ];

    /**
     * @When I click on :menuPoint patient summary left menu point
     *
     * @param string $menuPoint
     */
    public function clickLeftMenu($menuPoint)
    {
        $this->findAndClickText('a', $menuPoint);
    }

    /**
     * @When I select :option option in letter template selector
     *
     * @param string $option
     */
    public function chooseLetterTemplate($option)
    {
        $selector = $this->findCss('form[name="create_letter"] select[name="template"]');
        $selector->selectOption($option);
    }

    /**
     * @Then I see summary left menu with these points:
     *
     * @param TableNode $table
     */
    public function testPatientSummaryLeftMenu(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'name');
        $menu = $this->findAllCss('ul#summ_nav > li > a');
        foreach ($expected as $key => $expectedPoint) {
            $trimmed = trim(preg_replace('/\(.*?\)/', '', $menu[$key]->getText()));
            Assert::assertEquals($expectedPoint, $trimmed);
        }
    }

    /**
     * @Then I see patient summary subpoints:
     *
     * @param TableNode $table
     */
    public function testPatientSummarySubpoints(TableNode $table)
    {
        $expected = array_column($table->getHash(), 'name');
        $subpoints = $this->findAllCss('div#sect_summ h4');
        foreach ($expected as $key => $expectedSubpoint) {
            $trimmed = str_replace(':', '', $subpoints[$key]->getText());
            Assert::assertEquals($expectedSubpoint, $trimmed);
        }
    }

    /**
     * @Then I see add sleep study form:
     *
     * @param TableNode $table
     */
    public function testAddSleepStudyForm(TableNode $table)
    {
        // @todo: add this method once it can be reverted
    }

    /**
     * @Then I see :heading letter table
     *
     * @param string $heading
     */
    public function testLetterTable($heading)
    {
        $tableHeader = $this->findElementWithText('h2', $heading);
        Assert::assertNotNull($tableHeader);
    }

    /**
     * @Then :heading letter table is empty
     *
     * @param string $heading
     */
    public function testEmptyLetterTable($heading)
    {
        $tables = $this->findAllCss('div#sect_letters table');
        $table = $tables[self::LETTER_TABLES[$heading]];
        Assert::assertEquals(1, count($this->findAllCss('tr', $table)));
    }

    /**
     * @Then :heading letter table contains data:
     *
     * @param string $heading
     * @param TableNode $expectedTable
     */
    public function testLetterTableData($heading, TableNode $expectedTable)
    {
        $tables = $this->findAllCss('div#sect_letters table');
        $table = $tables[self::LETTER_TABLES[$heading]];
        $expectedRows = $expectedTable->getHash();
        foreach ($expectedRows as $key => $row) {
            $childNumber = $key + 2;
            $zeroIndexedRow = array_values($row);
            $columns = $this->findAllCss("tbody > tr:nth-child($childNumber) > td", $table);
            foreach ($columns as $columnKey => $column) {
                $trimmed = $this->sanitizeText(str_replace('Delete', '', $column->getText()));
                Assert::assertEquals($zeroIndexedRow[$columnKey], $trimmed);
            }
        }
    }

    /**
     * @Then I see letter template selector
     */
    public function testLetterTemplateSelector()
    {
        $selector = $this->findCss('form[name="create_letter"] select[name="template"]');
        Assert::assertNotNull($selector);
    }

    /**
     * @Then I see select contacts checkbox list:
     *
     * @param TableNode $table
     */
    public function testContactsCheckboxList(TableNode $table)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $labels = array_column($table->getHash(), 'name');
        $checkboxes = $this->findAllCss('td#contacts input[type="checkbox"]');
        foreach ($checkboxes as $key => $checkbox) {
            if (!$checkbox->isVisible()) {
                unset($checkboxes[$key]);
            }
        }
        /** @var NodeElement[] $checkboxes */
        $checkboxes = array_values($checkboxes);
        foreach ($labels as $key => $label) {
            $div = $checkboxes[$key]->getParent();
            Assert::assertEquals($label, $this->sanitizeText($div->getText()));
        }
    }
}
