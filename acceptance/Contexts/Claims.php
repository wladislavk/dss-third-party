<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Claims extends BaseContext
{
    /**
     * @Then I see claims table with following sections:
     *
     * @param TableNode $table
     */
    public function testClaimsSections(TableNode $table)
    {
        $headings = $this->findAllCss('span.admin_head');
        $expectedHeadings = array_column($table->getHash(), 'section');
        foreach ($expectedHeadings as $key => $expectedHeading) {
            Assert::assertEquals($expectedHeading, $headings[$key]->getText());
        }
    }

    /**
     * @Then :section claims table section contains add buttons:
     *
     * @param string $section
     * @param TableNode $table
     */
    public function testClaimsSectionButtons($section, TableNode $table)
    {
        // @todo: add test when HTML is changed
    }
}
