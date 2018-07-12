<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\CoreDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Session;
use Data\Pages;
use PHPUnit\Framework\Assert;
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
     * @When I go to :page page
     *
     * @param string $page
     * @throws BehatException
     */
    public function goToCustomPage($page)
    {
        if (SUT_HOST == 'vue') {
            $this->wait(SHORT_WAIT_TIME);
        }
        if ($page == 'start') {
            if (SUT_HOST == 'vue') {
                return;
            }
            $this->visitStartPage();
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
        $this->acceptPrompt();
    }

    /**
     * @When I confirm browser alert with delay
     */
    public function browserConfirmWithDelay()
    {
        $this->wait(SHORT_WAIT_TIME);
        $this->acceptPrompt();
    }

    /**
     * @When I confirm browser alert by entering :input
     *
     * @param string $input
     */
    public function browserConfirmWithText(string $input)
    {
        try {
            $this->wait(SHORT_WAIT_TIME);
        } catch (UnexpectedAlertOpen $e) {
            $this->acceptPrompt($input);
            return;
        }
        $this->acceptPrompt($input);
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
            $buttonElement = $this->findElementWithText('a', $button);
        }
        $buttonElement->click();
    }

    /**
     * @When I click input button with text :button
     *
     * @param string $button
     * @throws BehatException
     */
    public function clickInputButton($button)
    {
        $buttonElements = $this->findAllCss('input[type="button"], input[type="submit"]');
        foreach ($buttonElements as $buttonElement) {
            if ($buttonElement->getValue() == $button) {
                $buttonElement->click();
                return;
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
        $this->wait(MEDIUM_WAIT_TIME);

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
     * @When I close the iframe
     */
    public function closeIFrame()
    {
        $this->getCommonClient()->switchToIFrame();
        $closeButton = $this->findCss('a#popupContactClose');
        $closeButton->click();
        $this->wait(MEDIUM_WAIT_TIME);
    }

    /**
     * @When I run mouse over :menuPoint menu point
     *
     * @param string $menuPoint
     * @throws BehatException
     */
    public function runMouseOverMenu($menuPoint)
    {
        $this->wait(SHORT_WAIT_TIME);
        $menu = $this->findCss('ul#homemenu');
        $parentNodeLink = $this->findElementWithText('a', $menuPoint, $menu);
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
        $this->wait(MEDIUM_WAIT_TIME);
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
     * @When I attach the file :file to :field
     *
     * @param string file
     * @param string field
     */
    public function attachFileToField(string $file, string $field)
    {
        $encodedFile = $this->base64EncodeFile($file);
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();
        $remotePath = $driver->getWebDriverSession()->file(['file' => $encodedFile]);
        $input = $this->findCss("input[type='file'][name='$field']");
        $input->attachFile($remotePath);
    }

    /**
     * @Then I see :link link
     *
     * @param string $link
     * @throws BehatException
     */
    public function testSeeLink($link)
    {
        $this->wait(SHORT_WAIT_TIME);
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
        $this->wait(MEDIUM_WAIT_TIME);
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
        $this->wait(SHORT_WAIT_TIME);
        $this->testBrowserConfirm($text);
    }

    /**
     * @Then I see browser alert with text :text as soon as possible
     *
     * @param string $text
     * @throws NoAlertOpenException
     * @throws BehatException
     */
    public function testBrowserAlertAsSoonAsPossible(string $text)
    {
        for (
            $numberOfTries = 0;
            $numberOfTries < self::NUMBER_OF_TRIES_FOR_ALERT_CHECKING;
            ++$numberOfTries
        ) {
            try {
                $realText = $this->getAlertText();
                break;
            } catch (NoAlertOpenException $e) {
                // do nothing
            }
        }

        if (!isset($realText)) {
            $realText = $this->getAlertText();
        }

        Assert::assertEquals($text, $realText);
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
        $this->wait(MEDIUM_WAIT_TIME);
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

        $this->wait(MEDIUM_WAIT_TIME);

        $welcomeDiv = $this->findCss('div.suckertreemenu');
        Assert::assertNotNull($welcomeDiv);
        Assert::assertContains('Welcome ' . $user, $welcomeDiv->getText());
    }

    /**
     * @Then the header of modal window is :heading
     *
     * @param string $heading
     */
    public function testModalHeader($heading)
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame('aj_pop');
        }
        $modalHeading = $this->findCss('h2');
        if ($modalHeading) {
            Assert::assertEquals($heading, $modalHeading->getText());
            return;
        }
        $tableHeading = $this->findCss('td.cat_head');
        Assert::assertEquals($heading, trim($tableHeading->getText()));
    }


    /**
     * @throws NoAlertOpenException
     * @throws BehatException
     */
    private function getAlertText(): string
    {
        switch (BROWSER) {
            case 'phantomjs':
                break;
            case 'chrome':
                /** @var CoreDriver $driver */
                $driver = $this->getSession()->getDriver();
                if ($driver instanceof Selenium2Driver) {
                    try {
                        $alertText = $driver->getWebDriverSession()->getAlert_text();
                    } catch (\Exception $exception) {
                        if ($this->isNoAlertOpenException($exception->getMessage())) {
                            throw new NoAlertOpenException('No alert open.');
                        }
                        throw new BehatException($exception->getMessage());
                    }

                    return (isset($alertText)) ? $alertText : '';
                }
                break;
        }
        return '';
    }

    private function isNoAlertOpenException(string $message): bool
    {
        if (strstr($message, 'no alert open')) {
            return true;
        }
        return false;
    }

    /**
     * @param string|null $input
     */
    private function acceptPrompt(string $input = null)
    {
        switch (BROWSER) {
            case 'phantomjs':
                break;
            case 'chrome':
                /** @var CoreDriver $driver */
                $driver = $this->getSession()->getDriver();
                if ($driver instanceof Selenium2Driver) {
                    if (!is_null($input)) {
                        $driver->getWebDriverSession()->postAlert_text(['text' => $input]);
                    }
                    $driver->getWebDriverSession()->accept_alert();
                }
                break;
        }
    }

    /**
     * @param string $file
     * @return string
     * @see https://stackoverflow.com/a/42117423/208067
     */
    private function base64EncodeFile(string $file)
    {
        if ($this->getMinkParameter('files_path')) {
            $rawMinkPath = $this->getMinkParameter('files_path');
            $minkPath = realpath($rawMinkPath);
            $fullPath = rtrim($minkPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $file;
            if (is_file($fullPath)) {
                $file = $fullPath;
            }
        }
        $tempZip = tempnam('', 'WebDriverZip');
        $zip = new \ZipArchive();
        $zip->open($tempZip, \ZipArchive::CREATE);
        $zip->addFile($file, basename($file));
        $zip->close();
        $encodedFile = base64_encode(file_get_contents($tempZip));
        unlink($tempZip);
        return $encodedFile;
    }
}
