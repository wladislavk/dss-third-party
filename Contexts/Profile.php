<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Profile extends BaseContext
{
    /**
     * @Then I see practice profile form that is filled with data:
     *
     * @param TableNode $table
     */
    public function testPracticeProfileForm(TableNode $table)
    {
        Assert::assertNotNull($this->findElementWithText('h3', 'Practice Profile'));
        $form = $this->findAllCss('form')[2];
        $rows = $this->findAllCss('div.detail', $form);
        /** @var NodeElement[] $visibleRows */
        $visibleRows = [];
        foreach ($rows as $row) {
            if ($row->isVisible()) {
                $visibleRows[] = $row;
            }
        }
        $expectedRows = $table->getHash();
        foreach ($expectedRows as $key => $row) {
            $label = $this->findCss('label', $visibleRows[$key]);
            $label = str_replace(':', '', $label->getText());
            $expectedLabel = $row['field'];
            if (strstr($expectedLabel, '...')) {
                Assert::assertContains(str_replace('...', '', $expectedLabel), $label);
            } else {
                Assert::assertEquals($expectedLabel, $label);
            }
            switch ($row['type']) {
                case 'text':
                    $input = $this->findCss('input', $visibleRows[$key]);
                    Assert::assertEquals($row['value'], $input->getValue());
                    break;
                case 'radio':
                    // @todo: change HTML to test it
                    break;
            }
        }
    }
}
