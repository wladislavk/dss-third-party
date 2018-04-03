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
     * @Given I am logged in as admin :admin
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
     */
    public function browserConfirm()
    {
        switch (BROWSER) {
            case 'phantomjs':
                break;
            case 'chrome':
                /** @var CoreDriver $driver */
                $driver = $this->getSession()->getDriver();
                if ($driver instanceof Selenium2Driver) {
                    $driver->getWebDriverSession()->accept_alert();
                }
                break;
        }
    }

    /**
     * @When I confirm browser alert with delay
     */
    public function browserConfirmWithDelay()
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $this->browserConfirm();
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
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickButton($button)
    {
        $buttonElement = $this->findElementWithText('button', $button, null, true);
        if (!$buttonElement) {
            $buttonElement = $this->findElementWithText('a[contains(@class, "addButton")]', $button, null, true);
        }
        if (!$buttonElement) {
            $buttonElement = $this->findElementWithText('a', $button);
        }
        $buttonElement->click();
    }

    /**
     * @When I click button with text :button in popup window
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickButtonInIframe($button)
    {
        $iframe = 'modal-iframe';
        $this->client->switchToIFrame($iframe);
        $this->clickButton($button);
        $this->wait(self::SHORT_WAIT_TIME);
        $this->client->switchToIFrame();
    }

    /**
     * @When I click input button with text :button
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickInputButton($button)
    {
        $buttonElements = $this->findAllCss('input[type="button"]');
        foreach ($buttonElements as $buttonElement) {
            if ($buttonElement->getValue() == $button) {
                $buttonElement->click();
            }
        }
        throw new BehatException('Button element not found');
    }

    /**
     * @When I click add button with text :button
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickAddButton($button)
    {
        $buttonElements = $this->findAllCss('button.addButton');
        foreach ($buttonElements as $buttonElement) {
            if ($button == trim($buttonElement->getText())) {
                $buttonElement->click();
                return;
            }
        }
        $inputButtonElements = $this->findAllCss('input[type="button"].addButton');
        foreach ($inputButtonElements as $inputButtonElement) {
            if ($button == trim($inputButtonElement->getAttribute('value'))) {
                $inputButtonElement->click();
                return;
            }
        }
        $inputSubmitElements = $this->findAllCss('input[type="submit"].addButton');
        foreach ($inputSubmitElements as $inputSubmitElement) {
            if ($button == trim($inputSubmitElement->getAttribute('value'))) {
                $inputSubmitElement->click();
                return;
            }
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
     *
     * @param string $menuPoint
     * @throws BehatException
     */
    public function runMouseOverMenu($menuPoint)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $menu = $this->findCss('ul#homemenu');
        $parentNodeLink = $this->findElementWithText('a', $menuPoint, $menu);
        $parentNode = $parentNodeLink->getParent();
        $parentNode->mouseOver();
    }

    /**
     * @When I run mouse over :menuPoint admin menu point
     *
     * @param string $menuPoint
     * @throws BehatException
     */
    public function runMouseOverAdminMenu($menuPoint)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $menu = $this->findCss('ul.page-sidebar-menu');
        Assert::assertNotNull($menu);
        $parentNodeLink = $this->findElementWithText('a', $menuPoint, $menu);
        Assert::assertNotNull($parentNodeLink);
        $parentNode = $parentNodeLink->getParent();
        $parentNode->mouseOver();
    }

    /**
     * @When I run mouse over :menuPoint admin top menu point
     *
     * @param string $menuPoint
     * @throws BehatException
     */
    public function runMouseOverAdminTopMenu($menuPoint)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $menu = $this->findCss('div.top-menu ul.nav');
        Assert::assertNotNull($menu);
        $parentNodeLink = $this->findElementWithText('a/span', $menuPoint, $menu);
        Assert::assertNotNull($parentNodeLink);
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
     *
     * @param string $marker
     * @param string $button
     * @throws BehatException
     */
    public function testSeeMarker($marker, $button)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $buttonElement = $this->findElementWithText('button | //a', $button, null, true);
        Assert::assertNotNull($buttonElement);
        $markerElement = $buttonElement->find('css', ".fa.fa-$marker");
        Assert::assertNotNull($markerElement);
        Assert::assertTrue($markerElement->isVisible());
    }

    /**
     * @Then I see marker :marker in button :button in popup window
     *
     * @param string $marker
     * @param string $button
     * @throws BehatException
     */
    public function testSeeMarkerInIframe($marker, $button)
    {
        $iframe = 'modal-iframe';
        $this->client->switchToIFrame($iframe);
        $this->wait(self::MEDIUM_WAIT_TIME);
        $this->testSeeMarker($marker, $button);
        $this->client->switchToIFrame();
    }

    /**
     * @Then I see :page page
     *
     * @param string $page
     */
    public function testSeePage($page)
    {
        $title = $this->findCss('span.admin_head');
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
     *
     * @param string $text
     */
    public function testSeeText($text)
    {
        Assert::assertContains($text, $this->page->getText());
    }

    /**
     * @Then I see :text text with delay
     *
     * @param string $text
     */
    public function testSeeTextWithDelay($text)
    {
        $maxWait = 6;

        for ($n = 0; $n < $maxWait; $n++) {
            try {
                $this->wait(self::SHORT_WAIT_TIME);
                Assert::assertContains($text, $this->page->getText());
                return;
            } catch (ExpectationFailedException $e) { /* Fall through */ }
        }
        $screenshot = $this->client->getScreenshot();
        Assert::assertContains($text, $this->page->getText());
    }

    /**
     * @Then I see :text text in popup window
     *
     * @param string $text
     */
    public function testSeeTextInIframe($text)
    {
        $iframe = 'modal-iframe';
        $this->client->switchToIFrame($iframe);
        Assert::assertContains($text, $this->page->getText());
        $this->client->switchToIFrame();
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
     *
     * @param string $text
     */
    public function testBrowserAlert($text)
    {
        $this->wait(self::SHORT_WAIT_TIME);
        $this->testBrowserConfirm($text);
    }

    /**
     * @Then I see browser alert with text :text with delay
     *
     * @param string $text
     * @throws BehatException
     */
    public function testBrowserAlertWithDelay($text)
    {
        $maxWait = 6;

        for ($n = 0; $n < $maxWait; $n++) {
            try {
                $this->wait(self::SHORT_WAIT_TIME);
            } catch (UnexpectedAlertOpen $e) {
                $this->testBrowserConfirm($text);
                return;
            }
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
