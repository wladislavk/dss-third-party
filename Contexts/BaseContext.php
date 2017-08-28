<?php

namespace Contexts;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\Element;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;

require_once __DIR__ . '/../config.php';

abstract class BaseContext extends RawMinkContext
{
    const REALLY_LONG_WAIT_TIME = 30000;
    const RATHER_LONG_WAIT_TIME = 10000;
    const LONG_WAIT_TIME = 5000;
    const MEDIUM_WAIT_TIME = 2000;
    const SHORT_WAIT_TIME = 500;
    const VERY_SHORT_WAIT_TIME = 200;

    const NUMBER_OF_TRIES = 3;

    const REQUIRED_HTML = '<span class="red">*</span>';

    const PASSWORDS = [
        'doc1f' => 'cr3at1vItY',
    ];

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
        $this->getMink()->stopSessions();

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
     * @param NodeElement|null $parentElement
     * @return NodeElement|null
     */
    protected function findCss($selector, NodeElement $parentElement = null)
    {
        if (!$parentElement) {
            $parentElement = $this->page;
        }
        return $parentElement->find('css', $selector);
    }

    /**
     * @param string $selector
     * @param NodeElement|null $parentElement
     * @return NodeElement[]
     */
    protected function findAllCss($selector, NodeElement $parentElement = null)
    {
        if (!$parentElement) {
            $parentElement = $this->page;
        }
        return $parentElement->findAll('css', $selector);
    }

    /**
     * @param string $selector
     * @param string $text
     * @param Element|null $parentElement
     * @param bool $allowNull
     * @return NodeElement|null
     * @throws BehatException
     */
    protected function findElementWithText($selector, $text, Element $parentElement = null, $allowNull = false)
    {
        if (!$parentElement) {
            $parentElement = $this->page;
        }
        $element = $parentElement->find('xpath', '//' . $selector . '[text()="' . $text . '"]');
        if (!$element && !$allowNull) {
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

    protected function visitStartPage()
    {
        $this->getCommonClient()->visit(START_URL);
    }

    protected function login($user, $password = '')
    {
        if (!$password && array_key_exists($user, self::PASSWORDS)) {
            $password = self::PASSWORDS[$user];
        }
        $this->page->fillField('username', $user);
        $this->page->fillField('password', $password);
        $loginButton = $this->findCss('input[value=" Login "]');
        $loginButton->click();
    }

    /**
     * @todo: this function should be deleted when redirects are fixed
     */
    protected function reloadStartPage()
    {
        $this->visitStartPage();
        $this->getCommonClient()->wait(self::SHORT_WAIT_TIME);
        $this->page = $this->getCommonClient()->getPage();
    }

    /**
     * @param string $text
     * @return string
     */
    protected function sanitizeText($text)
    {
        $text = preg_replace('/\s{2,}/', ' ', $text);
        $text = trim($text);
        return $text;
    }

    /**
     * @param NodeElement $element
     * @param string $type
     * @return bool
     */
    protected function checkFormElement(NodeElement $element, $type)
    {
        $html = $this->sanitizeText($element->getHtml());
        switch ($type) {
            case 'text':
                // fall through
            case 'file':
                // fall through
            case 'checkbox':
                $input = $this->findCss("input[type=\"$type\"]", $element);
                if ($input) {
                    return true;
                }
                return false;
            case 'date':
                $input = $this->findCss("input[type=\"text\"]", $element);
                if ($input && strstr($input->getAttribute('class'), 'calendar')) {
                    return true;
                }
                return false;
            case 'select':
                if (strstr($html, '<select')) {
                    return true;
                }
                return false;
            case 'textarea':
                if (strstr($html, '<textarea')) {
                    return true;
                }
                return false;
        }
        return false;
    }

    /**
     * @param NodeElement $element
     * @param string $isRequired
     * @return bool
     */
    protected function checkRequiredFormElement(NodeElement $element, $isRequired)
    {
        $html = $this->sanitizeText($element->getHtml());
        $pattern = '/.*?\<span.*?\>\*\<\/span\>.*?/';
        if ($isRequired == 'yes') {
            if (preg_match($pattern, $html)) {
                return true;
            }
            return false;
        }
        if (preg_match($pattern, $html)) {
            return false;
        }
        return true;
    }

    protected function executeQuery($sql)
    {
        $host = getenv('DB_HOST');
        $dbName = getenv('DB_DATABASE');
        $dsn = "mysql:dbname=$dbName;host=$host";
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        $dbh = new \PDO($dsn, $user, $password);
        $dbh->exec($sql);
        unset($dbh);
    }
}
