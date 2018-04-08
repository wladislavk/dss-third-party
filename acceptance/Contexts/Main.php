<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\CoreDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use Data\Pages;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use WebDriver\Exception\UnexpectedAlertOpen;

class Main extends BaseContext
{
    /**
     * @return Session
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @Given I am logged in as :user
     *
     * @param string $user
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function loginAsUser($user)
    {
        $this->visitStartPage();
        $this->login($user);
    }

    /**
     * @When I am logged in as admin :admin
     *
     * @param string $admin
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function loginAsAdmin($admin)
    {
        $password = '';

        if (array_key_exists($admin, self::PASSWORDS)) {
            $password = self::PASSWORDS[$admin];
        }

        $this->visitAdminStartPage();
        $this->adminLogin($admin, $password, self::CAPTCHA_PASSPHRASE);
    }

    /**
     * @When I go to :page page
     *
     * @param string $page
     * @throws BehatException
     */
    public function goToCustomPage($page)
    {
        if (SUT_HOST == 'vue') {
            $this->wait(self::SHORT_WAIT_TIME);
        }
        if ($page == 'start') {
            if (SUT_HOST == 'vue') {
                return;
            }
            $this->visitStartPage();
            return;
        }
        if ($page == 'admin start') {
            if (SUT_HOST == 'vue') {
                return;
            }
            $this->visitAdminStartPage();
            return;
        }
        $url = Pages::getUrl($page);
        $this->getCommonClient()->visit($url);
    }

    /**
     * @When I confirm browser alert
     * @When I confirm browser alert with :delay
     * @When I confirm browser alert after :delay
     *
     * @param string $withDelay
     */
    public function browserConfirm($withDelay='')
    {
        if (BROWSER === 'chrome') {
            /** @var CoreDriver $driver */
            $driver = $this->getSession()->getDriver();
            if (!($driver instanceof Selenium2Driver)) {
                return;
            }
            if (strlen($withDelay) === 0) {
                $driver->getWebDriverSession()->accept_alert();
                return;
            }
            // Alert will open while the script waits, raising an exception
            try {
                $this->wait(self::SHORT_WAIT_TIME);
            } catch (UnexpectedAlertOpen $e) {
                /* Fall through */
            }
            $driver->getWebDriverSession()->accept_alert();
        }
    }

    /**
     * @When I click :link link
     *
     * @param string $link
     * @throws BehatException
     */
    public function clickLink($link)
    {
        $this->findAndClickText('a', $link);
    }

    /**
     * @When I click button with text :button
     * @When I click button with text :button in :popup window
     * @When I click button with text :button in :section :popup window
     *
     * @param string $button
     * @param string $popup
     * @param string $section
     * @throws BehatException
     */
    public function clickButton($button, $popup='', $section='')
    {
        if ($popup) {
            $this->focusPopupWindow($section);
        }
        $buttonElement = $this->findElementWithText('button', $button, null, true);
        if (!$buttonElement) {
            $buttonElement = $this->findElementWithText('a[contains(@class, "addButton")]', $button, null, true);
        }
        if (!$buttonElement) {
            $buttonElement = $this->findElementWithText('a', $button);
        }
        $buttonElement->click();
        if ($popup) {
            $this->wait(self::SHORT_WAIT_TIME);
            $this->focusMainWindow();
        }
    }

    /**
     * @When I click input button with text :button
     * @When I click input button with text :button in :popup window
     * @When I click input button with text :button in :section :popup window
     * @When I click input button with text :button triggering :alert
     * @When I click input button with text :button in :popup window triggering :alert
     * @When I click input button with text :button in :section :popup window triggering :alert
     *
     * @param string $button
     * @param string $popup
     * @param string $section
     * @param string $alert
     * @throws BehatException
     */
    public function clickInputButton($button, $popup='', $section='', $alert='')
    {
        if ($popup) {
            $this->focusPopupWindow($section);
        }
        $buttonElement = $this->findCss("input[type='button'][value='$button'], input[type='submit'][value='$button']");
        if (is_null($buttonElement)) {
            throw new BehatException("Button element '$button' not found");
        }
        if (strlen($alert) === 0) {
            $buttonElement->click();
            if ($popup) {
                $this->focusMainWindow();
            }
            return;
        }
        try {
            $buttonElement->click();
        } catch (UnexpectedAlertOpen $e) {
            if ($popup) {
                $this->focusMainWindow();
            }
            return;
        }
        throw new BehatException("Button element '$button' did not trigger a browser alert");
    }

    /**
     * @When I click add button with text :button
     * @When I click add button with text :button in :popup window
     * @When I click add button with text :button in :section :popup window
     *
     * @param string $button
     * @param string $popup
     * @param string $section
     * @throws BehatException
     */
    public function clickAddButton($button, $popup='', $section='')
    {
        if ($popup) {
            $this->focusPopupWindow($section);
        }
        $buttonElements = $this->findAllCss('button.addButton');
        foreach ($buttonElements as $buttonElement) {
            if ($button == trim($buttonElement->getText())) {
                $buttonElement->click();
                if ($popup) {
                    $this->focusMainWindow();
                }
                return;
            }
        }
        $inputButtonElements = $this->findAllCss('input[type="button"].addButton');
        foreach ($inputButtonElements as $inputButtonElement) {
            if ($button == trim($inputButtonElement->getAttribute('value'))) {
                $inputButtonElement->click();
                if ($popup) {
                    $this->focusMainWindow();
                }
                return;
            }
        }
        $inputSubmitElements = $this->findAllCss('input[type="submit"].addButton');
        foreach ($inputSubmitElements as $inputSubmitElement) {
            if ($button == trim($inputSubmitElement->getAttribute('value'))) {
                $inputSubmitElement->click();
                if ($popup) {
                    $this->focusMainWindow();
                }
                return;
            }
        }
        if ($popup) {
            $this->focusMainWindow();
        }
        throw new BehatException("Button with text $button not found");
    }

    /**
     * @When I type :name into patient search form
     *
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillPatientSearchForm($name)
    {
        $this->page->fillField('patient_search', $name);
    }

    /**
     * @When I type :name into user search form
     *
     * @param string $name
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillUserSearchForm($name)
    {
        $this->page->fillField('search', $name);
    }

    /**
     * @When I fill in :field with :value in popup window
     * @When I fill in :field with :value in :section popup window
     *
     * @param string $field
     * @param string $value
     * @param string $section
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function fillFieldInIframe($field, $value, $section='')
    {
        $this->focusPopupWindow($section);
        $this->page->fillField($field, $value);
        $this->focusMainWindow();
    }

    /**
     * @When I close the iframe
     */
    public function closeIFrame()
    {
        $this->getCommonClient()->switchToIFrame();
        $closeButton = $this->findCss('a#popupContactClose');
        $closeButton->click();
        $this->wait(self::MEDIUM_WAIT_TIME);
    }

    /**
     * @When I run mouse over :menuPoint menu point
     * @When I run mouse over :menuPoint :section menu point
     * @When I run mouse over :menuPoint :section :position menu point
     *
     * @param string $menuPoint
     * @param string $section
     * @param string $position
     * @throws BehatException
     */
    public function runMouseOverMenu($menuPoint, $section='', $position='')
    {
        $parentSelector = 'ul#homemenu';
        $childSelector = 'a';
        if ($section === 'admin') {
            $parentSelector = 'ul.page-sidebar-menu';
            
            if ($position === 'top') {
                $parentSelector = 'div.top-menu ul.nav';
                $childSelector = 'a/span';
            }
        }
        $this->wait(self::SHORT_WAIT_TIME);
        $menu = $this->findCss($parentSelector);
        $parentNodeLink = $this->findElementWithText($childSelector, $menuPoint, $menu);
        $parentNode = $parentNodeLink->getParent();
        $parentNode->mouseOver();
    }

    /**
     * @When I click on :name in list of patients
     *
     * @param string $name
     * @throws BehatException
     */
    public function clickPatientInList($name)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $patients = $this->findAllCss('ul#patient_list li.json_patient');
        foreach ($patients as $patient) {
            if ($this->sanitizeText($patient->getText()) == $name) {
                $patient->click();
                return;
            }
        }
        throw new BehatException("Patient with name $name not found");
    }

    /**
     * @When I click on logo in top left corner
     *
     * @throws BehatException
     */
    public function clickLogo()
    {
        $this->clickLink('Dashboard');
    }

    /**
     * @Then I see :link link
     *
     * @param string $link
     * @throws BehatException
     */
    public function testSeeLink($link)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        Assert::assertNotNull($this->findElementWithText('a', $link));
    }

    /**
     * @Then I see button with text :button
     *
     * @param string $button
     * @throws BehatException
     */
    public function testSeeButton($button)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $exists = false;
        $buttonElement = $this->findElementWithText('button', $button, null, true);
        if ($buttonElement) {
            $exists = true;
        } else {
            $linkElement = $this->findElementWithText('a', $button, null, true);
            if ($linkElement) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @Then I see input button with text :button
     *
     * @param string $button
     */
    public function testSeeInputButton($button)
    {
        $buttonElements = $this->findAllCss('input[type="button"]');
        $exists = false;
        foreach ($buttonElements as $buttonElement) {
            if ($buttonElement->getValue() == $button) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @Then I see add button with text :button
     *
     * @param string $button
     */
    public function testSeeAddButton($button)
    {
        $exists = false;
        $buttonElements = $this->findAllCss('button.addButton');
        foreach ($buttonElements as $buttonElement) {
            if ($button == trim($buttonElement->getText())) {
                $exists = true;
            }
        }
        $inputButtonElements = $this->findAllCss('input[type="button"].addButton');
        foreach ($inputButtonElements as $inputButtonElement) {
            if ($button == trim($inputButtonElement->getAttribute('value'))) {
                $exists = true;
            }
        }
        $inputSubmitElements = $this->findAllCss('input[type="submit"].addButton');
        foreach ($inputSubmitElements as $inputSubmitElement) {
            if ($button == trim($inputSubmitElement->getAttribute('value'))) {
                $exists = true;
            }
        }
        Assert::assertTrue($exists);
    }

    /**
     * @Then I see marker :marker in button :button
     * @Then I see marker :marker in button :button in :popup window
     * @Then I see marker :marker in button :button in :section :popup window
     *
     * @param string $marker
     * @param string $button
     * @param string $popup
     * @param string $section
     * @throws BehatException
     */
    public function testSeeMarker($marker, $button, $popup='', $section='')
    {
        if ($popup) {
            $this->focusPopupWindow($section);
            $this->wait(self::MEDIUM_WAIT_TIME);
        }
        $this->wait(self::SHORT_WAIT_TIME);
        $buttonElement = $this->findElementWithText('button | //a', $button, null, true);
        Assert::assertNotNull($buttonElement);
        $markerElement = $buttonElement->find('css', ".fa.fa-$marker");
        Assert::assertNotNull($markerElement);
        Assert::assertTrue($markerElement->isVisible());
        if ($popup) {
            $this->focusMainWindow();
        }
    }

    /**
     * @Then I see :page page
     *
     * @param string $page
     */
    public function testSeePage($page)
    {
        $title = $this->findCss('span.admin_head, .page-title');
        Assert::assertNotNull($title);
        Assert::assertEquals($page, trim($title->getText()));
    }

    /**
     * @Then I see list that contains :pages pages and I am on page :currentPage
     *
     * @param string $pages
     * @param string $currentPage
     */
    public function testPagedList($pages, $currentPage)
    {
        $pagesColumn = $this->findCss('table > tbody > tr:first-child > td.bp');
        if (!$pagesColumn) {
            $pagesColumn = $this->findCss('div.letters-pager');
        }
        Assert::assertContains('Page', $pagesColumn->getText());
        $numberOfLinks = count($this->findAllCss('a', $pagesColumn));
        Assert::assertEquals($pages - 1, $numberOfLinks);
        $boldPage = $this->findCss('strong', $pagesColumn);
        Assert::assertEquals($currentPage, $boldPage->getText());
    }

    /**
     * @Then I see :text text
     * @Then I see :text text in :popup window
     * @Then I see :text text in :section :popup window
     * @Then I see :text text with :delay
     * @Then I see :text text after :delay
     *
     * @param string $text
     * @param string $popup
     * @param string $section
     * @param string $delay
     */
    public function testSeeText($text, $popup='', $section='', $delay='')
    {
        if ($delay) {
            $this->wait(self::LONG_WAIT_TIME);
        }
        if ($popup) {
            $this->focusPopupWindow($section);
        }
        Assert::assertContains($text, $this->page->getText());
        if ($popup) {
            $this->focusMainWindow();
        }
    }

    /**
     * @Then I see table with columns:
     *
     * @param TableNode $table
     */
    public function testTableColumns(TableNode $table)
    {
        $columns = $this->findAllCss('tr.tr_bg_h > td.col_head');
        $expected = array_column($table->getHash(), 'name');
        foreach ($expected as $key => $column) {
            $linkText = $this->sanitizeText($columns[$key]->getText());
            Assert::assertEquals($column, $linkText);
        }
    }

    /**
     * @Then I see browser confirmation dialog with text :text
     *
     * @param string $text
     */
    public function testBrowserConfirm($text)
    {
        $realText = $this->getDriverSession()->getAlert_text();
        Assert::assertEquals($text, $realText);
    }

    /**
     * @Then I see browser alert with text :text
     * @Then I see browser alert with text :text with :delay
     * @Then I see browser alert with text :text after :delay
     *
     * @param string $text
     * @param string $delay
     * @throws BehatException
     */
    public function testBrowserAlert($text, $delay='')
    {
        if (strlen($delay) === 0) {
            $this->wait(self::SHORT_WAIT_TIME);
            $this->testBrowserConfirm($text);
            return;
        }
        try {
            $this->wait(self::LONG_WAIT_TIME);
        } catch (UnexpectedAlertOpen $e) {
            $realText = $this->getDriverSession()->getAlert_text();
            Assert::assertEquals($text, $realText);
            return;
        }
        throw new BehatException('No alert open');
    }

    /**
     * @Then I see :header table
     *
     * @param string $header
     */
    public function testTableHeader($header)
    {
        $spanHeader = $this->findCss('span.admin_head');
        Assert::assertEquals($header, trim($spanHeader->getText()));
    }

    /**
     * @Then the modal window is :status
     *
     * @param string $status
     */
    public function testModalWindow($status)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame();
        }
        $modal = $this->findCss('div#popupContact');
        if (SUT_HOST == 'vue') {
            $modal = $this->findCss('div#modal');
        }
        Assert::assertNotNull($modal);
        if ($status == 'open') {
            Assert::assertTrue($modal->isVisible());
            return;
        }
        Assert::assertFalse($modal->isVisible());
    }

    /**
     * @Then I see main page with welcome text for user :user
     *
     * @param string $user
     */
    public function testSeeWelcomeText($user)
    {
        if (SUT_HOST != 'vue') {
            $this->reloadStartPage();
        }

        $this->wait(self::MEDIUM_WAIT_TIME);

        $welcomeDiv = $this->findCss('div.suckertreemenu');
        Assert::assertNotNull($welcomeDiv);
        Assert::assertContains('Welcome ' . $user, $welcomeDiv->getText());
    }
}
