<?php

namespace Contexts;

use Behat\Behat\Context\Environment\InitializedContextEnvironment;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Mink\Driver\CoreDriver;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Element\Element;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\RawMinkContext;
use WebDriver\Exception\UnexpectedAlertOpen;

require_once __DIR__ . '/../config.php';

abstract class BaseContext extends RawMinkContext
{
    const START_URL = 'http://' . SUT_HOST . '/manage';
    const ADMIN_START_URL = self::START_URL . '/admin/home.php';

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
        'admin' => 'cr3at1vItY',
    ];

    const USER_POPUP_WINDOW = 'aj_pop';
    const ADMIN_POPUP_WINDOW = 'modal-iframe';
    const CAPTCHA_PASSPHRASE = 'deadbeef';

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

    /** @var \PDO */
    private $dbh;

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

        $host = getenv('DB_HOST');
        $dbName = getenv('DB_DATABASE');
        $dsn = "mysql:dbname=$dbName;host=$host";
        $user = getenv('DB_USERNAME');
        $password = getenv('DB_PASSWORD');

        $this->dbh = new \PDO($dsn, $user, $password);
        $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return string
     */
    private function getCommonContext()
    {
        return Main::class;
    }

    /**
     * @BeforeStep
     */
    public function beforeStep()
    {
        if (!$this->page) {
            $this->page = $this->getCommonClient()->getPage();
        }
    }

    /**
     * @return Session
     */
    protected function getCommonClient()
    {
        return $this->common->getClient();
    }

    /**
     * @param int $time
     */
    protected function wait($time)
    {
        $this->getSession()->wait($time);
        $this->page = $this->getCommonClient()->getPage();
    }

    /**
     * @param int $time
     */
    protected function waitExpectingBrowserAlert($time)
    {
        try {
            $this->wait($time);
        } catch (UnexpectedAlertOpen $e) {
            $this->confirmBrowserAlert();
        }
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
    public function findCss($selector, NodeElement $parentElement = null)
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
    public function findAllCss($selector, NodeElement $parentElement = null)
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
        $element = $parentElement->find('xpath', '//' . $selector . '[normalize-space()="' . $text . '"]');
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
        $element = $this->page->find('xpath', '//' . $selector . '[normalize-space()="' . $text . '"]');
        if (!$element) {
            throw new BehatException("Element with text $text not found");
        }
        $element->click();
    }

    protected function visitStartPage()
    {
        $url = self::START_URL;
        if (SUT_HOST == 'vue') {
            $url .= '/main';
        }
        $this->getCommonClient()->visit($url);
    }

    protected function visitAdminStartPage()
    {
        $this->getCommonClient()->visit(self::ADMIN_START_URL);
    }

    /**
     * @param string $user
     * @param string $password
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
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
     * @param string $admin
     * @param string $password
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    protected function adminLogin(string $admin, string $password='')
    {
        if (!$password && array_key_exists($admin, self::PASSWORDS)) {
            $password = self::PASSWORDS[$admin];
        }
        $this->page->fillField('username', $admin);
        $this->page->fillField('password', $password);
        $this->page->fillField('captcha', self::CAPTCHA_PASSPHRASE);
        $loginButton = $this->findCss('button[type="submit"]');
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

    /**
     * @param string $sql
     */
    protected function executeQuery($sql)
    {
        $this->dbh->exec($sql);
    }

    /**
     * @return \WebDriver\Session
     */
    protected function getDriverSession()
    {
        /** @var Selenium2Driver $driver */
        $driver = $this->getSession()->getDriver();
        $driverSession = $driver->getWebDriverSession();
        return $driverSession;
    }

    protected function confirmBrowserAlert()
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
     * @param string $section
     */
    protected function focusPopupWindow(string $section)
    {
        $iframe = self::USER_POPUP_WINDOW;
        if ($section === 'admin') {
            $iframe = self::ADMIN_POPUP_WINDOW;
        }
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame();
            $this->getCommonClient()->switchToIFrame($iframe);
        }
    }

    protected function focusMainWindow()
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame();
        }
    }
}
