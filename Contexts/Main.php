<?php

namespace Contexts;

use Behat\Mink\Session;
use PHPUnit\Framework\Assert;

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
     */
    public function loginAsUser($user)
    {
        $this->visitStartPage();
        $this->login($user);
        $this->visitStartPage();
    }

    /**
     * @When I visit start page
     */
    public function goToStart()
    {
        // do nothing
    }

    /**
     * @When I click :link link
     *
     * @param string $link
     */
    public function clickLink($link)
    {
        $this->findAndClickText('a', $link);
    }

    /**
     * @When I click button with text :button
     *
     * @param string $button
     */
    public function clickButton($button)
    {
        $buttonElement = $this->findElementWithText('button', $button);
        $buttonElement->click();
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
            if (trim($buttonElement->getText()) == $button) {
                $buttonElement->click();
                return;
            }
        }
        throw new BehatException("Button with text $button not found");
    }

    /**
     * @Then I see :link link
     *
     * @param string $link
     */
    public function testSeeLink($link)
    {
        Assert::assertNotNull($this->findElementWithText('a', $link));
    }

    /**
     * @Then I see button with text :button
     *
     * @param string $button
     */
    public function testSeeButton($button)
    {
        $buttonElement = $this->findElementWithText('button', $button);
        Assert::assertNotNull($buttonElement);
    }

    /**
     * @Then I see add button with text :button
     *
     * @param string $button
     */
    public function testSeeAddButton($button)
    {
        $buttonElement = $this->findCss('button.addButton');
        Assert::assertNotNull($buttonElement);
        Assert::assertEquals($button, trim($buttonElement->getText()));
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
        $form = $this->findCss('form[name="sortfrm"]');
        Assert::assertNotNull($form);
        $pagesColumn = $this->findCss('table > tbody > tr:first-child > td.bp');
        Assert::assertContains('Pages', $pagesColumn->getText());
        $numberOfLinks = count($this->findAllCss('a', $pagesColumn));
        Assert::assertEquals($pages - 1, $numberOfLinks);
        $boldPage = $this->findCss('strong', $pagesColumn);
        Assert::assertEquals($currentPage, $boldPage->getText());
    }
}
