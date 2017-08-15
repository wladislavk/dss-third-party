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
     * @When I run mouse over :menuPoint menu point
     *
     * @param string $menuPoint
     */
    public function runMouseOverMenu($menuPoint)
    {
        $menu = $this->findCss('ul#homemenu');
        $parentNodeLink = $this->findElementWithText('a', $menuPoint, $menu);
        $parentNode = $parentNodeLink->getParent();
        $parentNode->mouseOver();
    }

    /**
     * @Then I see right top bar with following links:
     *
     * @param TableNode $table
     */
    public function testRightTopBar(TableNode $table)
    {
        $topBar = $this->findCss('ul#topmenu2');
        $expectedLinks = array_column($table->getHash(), 'text');
        $links = $this->findAllCss('li', $topBar);
        foreach ($expectedLinks as $key => $expectedLink) {
            $realLink = trim($this->findCss('a', $links[$key])->getText());
            Assert::assertEquals($expectedLink, $realLink);
        }
    }

    /**
     * @Then I see :section dashboard section
     *
     * @param string $section
     */
    public function testDashboardSection($section)
    {
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
     * @Then notifications list contains the following data:
     *
     * @param TableNode $table
     */
    public function testNotificationsList(TableNode $table)
    {
        $tableContents = $table->getHash();
        $notificationLinks = $this->findAllCss('a.notification');
        foreach ($notificationLinks as $key => $link) {
            if (!$link->getText()) {
                unset($notificationLinks[$key]);
            }
        }
        /** @var NodeElement[] $notificationLinks */
        $notificationLinks = array_values($notificationLinks);
        $notificationLinkContents = [];
        foreach ($notificationLinks as $link) {
            $html = $link->getHtml();
            $html = preg_replace('/<\/span><span.*?>/', ' ', $html);
            $html = str_replace("\n", ' ', $html);
            $html = preg_replace('/\s{2,}/', ' ', $html);
            $notificationLinkContents[] = trim(strip_tags($html));
        }
        foreach ($tableContents as $row) {
            $linkKey = array_search($row['text'], $notificationLinkContents);
            Assert::assertNotFalse($linkKey);
            $class = self::NOTIFICATION_COLORS[$row['color']];
            $link = $notificationLinks[$linkKey];
            Assert::assertContains($class, $link->getAttribute('class'));
        }
    }

    /**
     * @Then I see checkboxes with these tasks under :section section:
     *
     * @param string $section
     * @param TableNode $table
     */
    public function testTasks($section, TableNode $table)
    {
        $taskMenu = $this->findAllCss('div.task_menu')[1];
        Assert::assertNotNull($this->findElementWithText('h4', $section, $taskMenu));
        $taskList = $this->findAllCss('ul.task_od_list li div:last-child');
        $taskTexts = [];
        foreach ($taskList as $task) {
            $taskTexts[] = trim($task->getText());
        }
        $taskNames = array_column($table->getHash(), 'task');
        foreach ($taskNames as $taskName) {
            Assert::assertNotFalse(array_search($taskName, $taskTexts));
        }
    }

    /**
     * @Then I see these messages:
     *
     * @param TableNode $table
     */
    public function testMessages(TableNode $table)
    {
        $messageList = $this->findAllCss('div.task_menu')[2];
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
}
