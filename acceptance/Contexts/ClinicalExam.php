<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class ClinicalExam extends BaseContext
{
    /**
     * @Then I see clinical exam menu with following sections:
     *
     * @param TableNode $table
     */
    public function testClinicalExamMenu(TableNode $table)
    {
        $expectedSections = array_column($table->getHash(), 'name');
        $sections = $this->findAllCss('div#contentMain > table > tbody > tr > td');
        foreach ($expectedSections as $key => $expectedSection) {
            $text = $this->sanitizeText($sections[$key]->getText());
            Assert::assertEquals($expectedSection, $text);
        }
    }
}
