<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class ProfileStripe extends BaseContext
{
    /**
     * @When I fill in the following credit card details:
     *
     * @param TableNode $table
     */
    public function fillCreditCardDetails(TableNode $table)
    {
        $fields = $table->getHash();
        $container = $this->findCss('div#card_form');
        Assert::assertNotNull($container);

        foreach ($fields as $field) {
            $label = $container->find('xpath', "//label[normalize-space()='{$field['label']}']");
            Assert::assertNotNull($label);
            $parent = $label->getParent();
            $input = $parent->find('xpath', '//input[@type="text"]');
            Assert::assertNotNull($input);
            // Field masks cause volatility if fields are not clicked first
            $input->click();
            $input->setValue($field['value']);
        }
    }
}
