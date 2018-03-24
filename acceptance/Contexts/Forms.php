<?php

namespace Contexts;


use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Forms extends BaseContext
{
    /**
     * @Then I can see following forms:
     *
     * @param TableNode $table
     */
    public function testPatientForms(TableNode $table)
    {
        $parentForm = $this->findCss('form[name="sortfrm"]');
        $expectedForms = array_column($table->getHash(), 'name');
        foreach ($expectedForms as $key => $expectedForm) {
            $childNumber = $key + 2;
            $column = $this->findCss("table > tbody> tr:nth-child($childNumber) > td:nth-child(1)", $parentForm);
            $formText = $this->sanitizeText($column->getText());
            Assert::assertEquals($expectedForm, $formText);
        }
    }
}
