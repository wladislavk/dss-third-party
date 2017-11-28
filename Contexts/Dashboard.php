<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Dashboard extends BaseContext
{
    const NOTIFICATION_COLORS = [
        'red' => 'bad_count',
        'blue' => 'good_count',
        'green' => 'great_count',
    ];

    /**
     * @When I click on :menuPoint menu point
     *
     * @param string $menuPoint
     */
    public function clickMenu($menuPoint)
    {
        $menu = $this->findCss('ul#homemenu');
        $nodeLink = $this->findElementWithText('a', $menuPoint, $menu);
        $nodeLink->click();
    }

    /**
     * @When I click on :menuPoint in notifications menu
     *
     * @param string $menuPoint
     * @throws BehatException
     */
    public function clickNotifications($menuPoint)
    {
        $this->wait(self::VERY_SHORT_WAIT_TIME);
        $spans = $this->findAllCss('a.notification > span.label');
        foreach ($spans as $span) {
            if ($span->getText() == $menuPoint) {
                $span->getParent()->click();
                return;
            }
        }
        throw new BehatException("Menu point with text $menuPoint not found");
    }

    /**
     * @When I run mouse over :point navigation point
     *
     * @param string $point
     * @throws BehatException
     */
    public function runMouseOverNavigation($point)
    {
        $menu = $this->findCss('ul#homemenu');
        $link = $this->findElementWithText('a', $point, $menu);
        if (!$link) {
            throw new BehatException("Cannot find menu point with text $point");
        }
        $link->mouseOver();
    }

    /**
     * @When I run mouse over :subPoint sub-point for :point navigation point
     *
     * @param string $subPoint
     * @param string $point
     * @throws BehatException
     */
    public function runMouseOverNavigationSubPoint($subPoint, $point)
    {
        $menu = $this->findCss('ul#homemenu');
        $link = $this->findElementWithText('a', $point, $menu);
        if (!$link) {
            throw new BehatException("Cannot find menu point with text $point");
        }
        $sublink = $this->findElementWithText('a', $subPoint, $link->getParent());
        if (!$sublink) {
            throw new BehatException("Cannot find menu point with text $subPoint");
        }
        $sublink->mouseOver();
    }

    /**
     * @When I run mouse over :notification notification
     *
     * @param string $notification
     * @throws BehatException
     */
    public function runMouseOverNotification($notification)
    {
        $notificationLinks = $this->findAllCss('a.notification');
        foreach ($notificationLinks as $link) {
            if ($link->getText() == $notification) {
                $link->mouseOver();
                return;
            }
        }
        throw new BehatException("Notification with text $notification not found");
    }

    /**
     * @Then I see :section dashboard section
     *
     * @param string $section
     */
    public function testDashboardSection($section)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        Assert::assertNotNull($this->findElementWithText('h3', $section));
    }

    /**
     * @Then navigation menu contains the following links:
     *
     * @param TableNode $table
     */
    public function testNavigationMenu(TableNode $table)
    {
        $tableContents = $table->getHash();
        $names = array_column($tableContents, 'name');
        $menu = $this->findCss('ul#homemenu');
        Assert::assertNotNull($menu);
        foreach ($names as $name) {
            Assert::assertNotNull($this->findElementWithText('a', $name, $menu));
        }
    }

    /**
     * @Then I see navigation sub-menu for :parent with the following links:
     *
     * @param string $parent
     * @param TableNode $table
     */
    public function testNavigationSubmenu($parent, TableNode $table)
    {
        $names = array_column($table->getHash(), 'name');
        $menu = $this->findCss('ul#homemenu');
        $parentLink = $this->findElementWithText('a', $parent, $menu);
        $points = $this->findAllCss('ul > li > a', $parentLink->getParent());
        foreach ($points as $pointKey => $point) {
            if (!$point->isVisible()) {
                unset($points[$pointKey]);
            }
        }
        /** @var NodeElement[] $points */
        $points = array_values($points);
        foreach ($names as $key => $name) {
            $pointText = $points[$key]->getText();
            Assert::assertEquals($name, $pointText);
        }
    }

    /**
     * @Then I see navigation sub-sub-menu for :parent under :grandparent with the following links:
     *
     * @param string $parent
     * @param string $grandparent
     * @param TableNode $table
     */
    public function testNavigationSubSubmenu($parent, $grandparent, TableNode $table)
    {
        $names = array_column($table->getHash(), 'name');
        $menu = $this->findCss('ul#homemenu');
        $grandparentLink = $this->findElementWithText('a', $grandparent, $menu);
        $parentLink = $this->findElementWithText('a', $parent, $grandparentLink->getParent());
        $points = $this->findAllCss('ul > li > a', $parentLink->getParent());
        foreach ($names as $key => $name) {
            Assert::assertEquals($name, $points[$key]->getText());
        }
    }

    /**
     * @Then notifications list contains the following data:
     *
     * @param TableNode $table
     */
    public function testNotificationsList(TableNode $table)
    {
        $tableContents = $table->getHash();
        $notificationLinks = $this->findAllCss('a.notification');
        foreach ($notificationLinks as $key => $link) {
            if (!$link->getText() || !$link->isVisible()) {
                unset($notificationLinks[$key]);
            }
        }
        /** @var NodeElement[] $notificationLinks */
        $notificationLinks = array_values($notificationLinks);
        $notificationLinkContents = [];
        foreach ($notificationLinks as $link) {
            $notificationLinkContents[] = $this->getTextFromHtml($link->getHtml());
        }
        foreach ($tableContents as $key => $row) {
            $class = self::NOTIFICATION_COLORS[$row['color']];
            $link = $notificationLinks[$key];
            $linkContent = $notificationLinkContents[$key];
            Assert::assertEquals($row['text'], $linkContent);
            Assert::assertContains($class, $link->getAttribute('class'));
        }
    }

    /**
     * @Then I see these messages:
     *
     * @param TableNode $table
     */
    public function testMessages(TableNode $table)
    {
        $taskLists = $this->findAllCss('div.task_menu');
        $messageList = $taskLists[count($taskLists) - 1];
        $messages = $this->findAllCss('li', $messageList);
        $messageTexts = [];
        foreach ($messages as $message) {
            $messageTexts[] = trim($message->getText());
        }
        $expectedMessages = array_column($table->getHash(), 'message');
        foreach ($expectedMessages as $message) {
            Assert::assertNotFalse(array_search($message, $messageTexts));
        }
    }

    /**
     * @Then I see notification sub-list for :parent with the following data:
     *
     * @param string $parent
     * @param TableNode $table
     */
    public function testNotificationSubList($parent, TableNode $table)
    {
        $tableContents = $table->getHash();
        $notificationLinks = $this->findAllCss('a.notification');
        $parentLink = null;
        foreach ($notificationLinks as $link) {
            $linkText = $this->getTextFromHtml($link->getHtml());
            if ($linkText == $parent) {
                $parentLink = $link;
                break;
            }
        }
        Assert::assertNotNull($parentLink);
        $contents = $this->findAllCss('ul > li > a', $parentLink->getParent());
        foreach ($tableContents as $key => $row) {
            $class = self::NOTIFICATION_COLORS[$row['color']];
            $link = $contents[$key];
            $linkText = $this->getTextFromHtml($link->getHtml());
            Assert::assertEquals($row['text'], $linkText);
            Assert::assertContains($class, $link->getAttribute('class'));
        }
    }

    /**
     * @param string $html
     * @return string
     */
    private function getTextFromHtml($html)
    {
        $html = preg_replace('/<\/span><span.*?>/', ' ', $html);
        $html = str_replace("\n", ' ', $html);
        $html = preg_replace('/\s{2,}/', ' ', $html);
        return trim(strip_tags($html));
    }
}
