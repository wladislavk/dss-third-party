<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Tasks extends BaseContext
{
    /**
     * @Then I see add task form with header :header
     *
     * @param string $header
     */
    public function testAddTaskForm($header)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $headerCell = $this->findCss('td.cat_head');
        Assert::assertNotNull($headerCell);
        Assert::assertEquals($header, $this->sanitizeText($headerCell->getText()));
    }

    /**
     * @Then add task form has following fields:
     *
     * @param TableNode $table
     */
    public function testAddTaskFormFields(TableNode $table)
    {
        $form = $this->findCss('form[name="notesfrm"]');
        $expectedRows = $table->getHash();
        $tableRows = $this->findAllCss("tbody > tr", $form);
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 1;
            $column = $this->findCss("td", $tableRows[$childNumber]);
            $label = $this->findCss('label', $column);
            $labelText = str_replace(':', '', $label->getText());
            Assert::assertEquals($row['field'], $labelText);
            $valueHtml = $this->sanitizeText($column->getHtml());
            if ($row['required'] == 'yes') {
                Assert::assertContains(self::REQUIRED_HTML, $valueHtml);
            } else {
                Assert::assertNotContains(self::REQUIRED_HTML, $valueHtml);
            }
            switch ($row['type']) {
                case 'text':
                    // fall through
                case 'checkbox':
                    $input = $this->findCss("input[type=\"{$row['type']}\"]", $column);
                    Assert::assertNotNull($input);
                    break;
                case 'date':
                    $input = $this->findCss("input[type=\"text\"]", $column);
                    Assert::assertNotNull($input);
                    Assert::assertContains('calendar', $input->getAttribute('class'));
                    break;
                case 'select':
                    Assert::assertContains('<select', $valueHtml);
                    break;
            }
        }
    }
}
