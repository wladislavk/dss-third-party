<?php

namespace Contexts;

use Behat\Mink\Exception\ElementNotFoundException;
use WebDriver\Exception\UnexpectedAlertOpen;

class Invoicing extends BaseContext
{
    /**
     * @When I add :card credit card to user :user
     *
     * @param string $user
     * @param string $card
     * @throws BehatException
     * @throws ElementNotFoundException
     */
    public function addCreditCardForUser(string $user, string $card)
    {
        $this->visitStartPage();
        $this->login($user);
        $menu = $this->page->find('css', '#homemenu a:contains("Admin")');
        if (!$menu) {
            throw new BehatException('Menu item not found');
        }
        $menu->mouseOver();
        $this->page->clickLink('Profile');
        $this->wait(self::SHORT_WAIT_TIME);
        $this->page->clickLink('Add');
        $this->fillField('card-number', $card);
        $this->fillField('card-cvc', '123');
        $this->fillField('card-expiry-month', '12');
        $this->fillField('card-expiry-year', (int)date('y') + 4);
        $this->fillField('card-name', 'Acceptance Test');
        $this->fillField('card-zip', '12345');
        $this->page->clickLink('Save');
        $this->waitExpectingBrowserAlert(self::LONG_WAIT_TIME);
        $this->wait(self::SHORT_WAIT_TIME);
        $success = $this->page->findLink('Update');
        if (!$success) {
            throw new BehatException("Card number $card was not added to user profile $user");
        }
        $this->page->clickLink('Sign Out');
        $this->waitExpectingBrowserAlert(self::LONG_WAIT_TIME);
        $this->wait(self::SHORT_WAIT_TIME);
        $loginTitle = $this->page->find('css', 'td.t_head');
        if (!$loginTitle) {
            throw new BehatException('Login screen title not found');
        }
        if ($loginTitle->getText() !== 'Please Enter Your Login Information') {
            throw new BehatException('Unable to logout from user section');
        }
    }

    /**
     * @When I click input button with text :button in admin popup window triggering alert
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickInputButtonInPopupWithAlert(string $button)
    {
        $this->focusPopupWindow('admin');
        $buttonElement = $this->findCss("input[type='button'][value='$button'], input[type='submit'][value='$button']");
        if (!$buttonElement) {
            throw new BehatException("Input button $button not found");
        }
        try {
            $buttonElement->click();
            $this->wait(self::SHORT_WAIT_TIME);
        } catch (UnexpectedAlertOpen $e) {
            /* Fall through */
        }
    }

    /**
     * @When I fill in :field with :value in admin popup window
     *
     * @param string $field
     * @param string $value
     * @throws ElementNotFoundException
     */
    public function fillFieldInPopup(string $field, string $value)
    {
        $this->focusPopupWindow('admin');
        $this->page->fillField($field, $value);
        $this->focusMainWindow();
    }

    /**
     * @param string $field
     * @param string $value
     */
    private function fillField(string $field, string $value)
    {
        $field = $this->page->findField($field);
        $field->click();
        $field->setValue($value);
    }
}
