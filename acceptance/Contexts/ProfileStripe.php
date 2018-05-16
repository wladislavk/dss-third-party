<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use PHPUnit\Framework\Assert;

class ProfileStripe extends BaseContext
{
    /**
     * @Then I see :text text in card details
     * @Then I see :text text in card details after :delay
     *
     * @param string $text
     * @param string $delay
     */
    public function testSeeTextInCardDetails(string $text, string $delay = '')
    {
        if ($delay) {
            $this->wait(MEDIUM_WAIT_TIME);
        }
        $title = $this->findCss('h3:contains("Credit Card Information")');
        Assert::assertNotNull($title);
        $container = $title->getParent();
        Assert::assertContains($text, $container->getText());
    }

    /**
     * @When I fill in the following credit card details:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillCreditCardDetails(TableNode $table)
    {
        $fields = $table->getHash();
        $container = $this->findCss('div#card_form');
        if (is_null($container)) {
            throw new BehatException('Credit card details container not found');
        }

        foreach ($fields as $field) {
            $label = $container->find('xpath', "//label[normalize-space()='{$field['label']}']");
            if (is_null($label)) {
                throw new BehatException("Label {$field['label']} not found");
            }
            $parent = $label->getParent();
            $input = $parent->find('xpath', '//input[@type="text"]');
            if (is_null($input)) {
                throw new BehatException("Input for label {$field['label']} not found");
            }
            // Field masks cause volatility if fields are not clicked first
            $input->click();
            $input->setValue($field['value']);
        }
    }
}
