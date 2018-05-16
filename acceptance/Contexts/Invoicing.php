<?php

namespace Contexts;

use Behat\Mink\Exception\ElementNotFoundException;
use WebDriver\Exception\UnexpectedAlertOpen;

class Invoicing extends BaseContext
{
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
            $this->wait(SHORT_WAIT_TIME);
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
