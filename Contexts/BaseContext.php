<?php

namespace Contexts;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;

abstract class BaseContext extends RawMinkContext
{
    const REALLY_LONG_WAIT_TIME = 30000;
    const RATHER_LONG_WAIT_TIME = 10000;
    const LONG_WAIT_TIME = 5000;
    const MEDIUM_WAIT_TIME = 2000;
    const SHORT_WAIT_TIME = 500;
    const VERY_SHORT_WAIT_TIME = 200;

    const NUMBER_OF_TRIES = 3;

    /**
     * @var DocumentElement
     */
    protected $page;

    /**
     * @var Session
     */
    protected $client;

    /**
     * @var Main
     */
    protected $common;

    /** @BeforeScenario
     *
     * @param BeforeScenarioScope $scope
     */
    public function beforeScenario(BeforeScenarioScope $scope)
    {
        /** @var InitializedContextEnvironment $environment */
        $environment = $scope->getEnvironment();
        $this->common = $environment->getContext($this->getCommonContext());
        $this->client = $this->getMink()->getSession();
    }

    /**
     * @return string
     */
    private function getCommonContext()
    {
        return Main::class;
    }

    /** @BeforeStep
     *
     */
    public function beforeStep()
    {
        $this->getCommonClient()->wait(self::SHORT_WAIT_TIME);
        $this->page = $this->getCommonClient()->getPage();
    }

    /**
     * @return Session
     */
    protected function getCommonClient()
    {
        return $this->common->getClient();
    }

    /**
     * @param string $css
     * @throws BehatException
     */
    protected function findAndClickElement($css)
    {
        $button = $this->page->find('css', $css);
        if (!$button) {
            throw new BehatException("Element with css $css not found");
        }
        $button->click();
    }

    /**
     * @param string $selector
     * @param string $text
     * @return NodeElement
     * @throws BehatException
     */
    protected function findElementWithText($selector, $text)
    {
        $element = $this->page->find('xpath', '//' . $selector . '[text()="' . $text . '"]');
        if (!$element) {
            throw new BehatException("Element with text $text not found");
        }
        return $element;
    }

    /**
     * @param string $selector
     * @param string $text
     * @throws BehatException
     */
    protected function findAndClickText($selector, $text)
    {
        $element = $this->page->find('xpath', '//' . $selector . '[text()="' . $text . '"]');
        if (!$element) {
            throw new BehatException("Element with text $text not found");
        }
        $element->click();
    }
}
