<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\ElementNotFoundException;
use PHPUnit\Framework\Assert;

class ProfileStripe extends BaseContext
{
    /**
     * @Given I delete Stripe data from user :user
     *
     * @param string $user
     * @throws BehatException
     * @throws ElementNotFoundException
     */
    public function deleteStripeData(string $user)
    {
        $this->visitAdminStartPage();
        $this->adminLogin('admin');
        $this->wait(self::SHORT_WAIT_TIME);
        $this->page->fillField('search', $user);
        $this->page->pressButton('Search user');
        $this->wait(self::SHORT_WAIT_TIME);
        $this->page->clickLink('Edit');
        $this->wait(self::SHORT_WAIT_TIME);
        $this->focusPopupWindow('admin');
        $this->page->clickLink('Delete Stripe data');
        $this->wait(self::LONG_WAIT_TIME);
        $success = $this->page->findLink('Delete Stripe data success');
        if (!$success) {
            throw new BehatException("Stripe data was not deleted for user $user");
        }
        $this->focusMainWindow();
        $this->page->pressButton('Close');
        $this->wait(self::SHORT_WAIT_TIME);
        $menu = $this->page->find('css', 'div.top-menu ul.nav a:contains("NathanAdmin SuperStage")');
        if (!$menu) {
            throw new BehatException('Admin top menu item not found');
        }
        $menu->mouseOver();
        $this->page->clickLink('Log Out');
        $this->waitExpectingBrowserAlert(self::SHORT_WAIT_TIME);
        $this->wait(self::SHORT_WAIT_TIME);
        $loginTitle = $this->page->find('css', 'h3.form-title');
        if (!$loginTitle) {
            throw new BehatException('Login screen title not found');
        }
        if ($loginTitle->getText() !== 'Login to your DS3 account') {
            throw new BehatException('Unable to logout from admin section');
        }
    }

    /**
     * @Then I see :text text in card details
     * @Then I see :text text in card details after :delay
     *
     * @param string $text
     * @param string $delay
     */
    public function testSeeTextInCardDetails(string $text, string $delay='')
    {
        if ($delay) {
            $this->wait(self::LONG_WAIT_TIME);
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
