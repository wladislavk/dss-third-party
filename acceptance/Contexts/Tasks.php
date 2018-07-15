<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use PHPUnit\Framework\Assert;

class Tasks extends TasksBaseContext
{
    private const TASK_MENUS = [
        'top menu' => 0,
        'patient menu' => 1,
        'dashboard' => -2,
    ];

    private const TASK_BUTTONS = [
        'delete' => 1,
        'edit' => 2,
    ];

    /**
     * @When I click on task :task checkbox in :area
     *
     * @param string $task
     * @param string $area
     * @throws BehatException
     */
    public function clickOnTask($task, $area)
    {
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $checkboxList = $this->findAllCss('input[type="checkbox"]', $taskMenu);
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                $checkboxList[$index]->click();
                $this->taskDeactivated = $task;
                return;
            }
        }
        throw new BehatException("Task with text $task not found");
    }

    /**
     * @When I click :type button next to task :task in :area
     *
     * @param string $type
     * @param string $task
     * @param string $area
     * @throws BehatException|UnsupportedDriverActionException|DriverException
     */
    public function clickOnButton($type, $task, $area)
    {
        $typeIndex = self::TASK_BUTTONS[$type];
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        $extraList = $this->findAllCss('ul li div:first-child', $taskMenu);
        $button = null;
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                $extra = $extraList[$index];
                $button = $this->findCss("a:nth-child($typeIndex)", $extra);
                if ($type == 'delete') {
                    $this->taskDeleted = $task;
                }
                $button->click();
                if (SUT_HOST == 'loader' && $type == 'edit') {
                    $this->wait(SHORT_WAIT_TIME);
                    $this->runMouseOverTask($task, $area);
                    $button = $this->findCss("a:nth-child($typeIndex)", $extra);
                    $button->click();
                }
                return;
            }
        }
        throw new BehatException("Task with text $task not found");
    }

    /**
     * @When I run mouse over task :task in :area
     *
     * @param string $task
     * @param string $area
     * @throws BehatException
     */
    public function runMouseOverTask($task, $area)
    {
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                $taskElement->getParent()->mouseOver();
                return;
            }
        }
        throw new BehatException("Task with text $task not found");
    }

    /**
     * @When I run mouse over :bullet bullet in top menu
     *
     * @param string $bullet
     * @throws BehatException
     */
    public function runMouseOverTopMenuBullet($bullet)
    {
        $header = $this->findCss('span#task_header');
        if (trim($header->getText()) != $bullet) {
            throw new BehatException("Bullet with text $bullet not found");
        }
        $header->mouseOver();
    }

    /**
     * @Then the :field form field is filled with value :value
     *
     * @param string $field
     * @param string $value
     */
    public function testAddTaskFormFieldData($field, $value)
    {
        $this->wait(SHORT_WAIT_TIME);
        $cells = $this->findAllCss('td.frmhead');

        $realValue = '';
        foreach ($cells as $cell) {
            $label = $this->findCss('label', $cell);
            if ($label && $label->getText() == $field) {
                $input = $this->findCss('input', $cell);
                $realValue = $input->getValue();
                break;
            }
        }
        Assert::assertEquals($value, $realValue);
    }

    /**
     * @Then I see these task sub-sections in :area:
     *
     * @param string $area
     * @param TableNode $table
     * @throws BehatException
     */
    public function testSubsections($area, TableNode $table)
    {
        $this->wait(SHORT_WAIT_TIME);
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $subsectionHeaders = $this->findAllCss('h4', $taskMenu);
        if ($area == 'dashboard') {
            array_shift($subsectionHeaders);
        }
        $expected = array_column($table->getHash(), 'section');
        Assert::assertEquals(sizeof($expected), sizeof($subsectionHeaders));
        foreach ($expected as $index => $text) {
            Assert::assertEquals($text, $subsectionHeaders[$index]->getText());
        }
    }

    /**
     * @param string $area
     * @param array $menus
     * @return NodeElement
     * @throws BehatException
     */
    private function getTaskMenu($area, array $menus)
    {
        $areaIndex = self::TASK_MENUS[$area];
        if ($areaIndex >= 0) {
            return $menus[$areaIndex];
        }
        $newIndex = count($menus) + $areaIndex;
        if (!isset($menus[$newIndex])) {
            throw new BehatException("Menu with index $newIndex does not exist");
        }
        return $menus[$newIndex];
    }

    /**
     * @Then I see checkboxes with these tasks under :section section in :area:
     *
     * @param string $section
     * @param string $area
     * @param TableNode $table
     * @throws BehatException
     */
    public function testTasks($section, $area, TableNode $table)
    {
        $this->wait(MEDIUM_WAIT_TIME);
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $headers = $this->findAllCss('h4', $taskMenu);
        $lists = $this->findAllCss('ul', $taskMenu);
        $headerFound = false;
        $listKey = 0;
        Assert::assertGreaterThan(0, sizeof($headers));
        foreach ($headers as $key => $header) {
            if ($header->getText() == $section) {
                $listKey = $key;
                $headerFound = true;
                break;
            }
        }
        Assert::assertTrue($headerFound);
        if ($area == 'dashboard') {
            $listKey -= 1;
        }
        Assert::assertArrayHasKey($listKey, $lists);
        Assert::assertNotNull($lists[$listKey]);
        $taskList = $this->findAllCss('li', $lists[$listKey]);
        $taskNames = array_column($table->getHash(), 'task');
        $taskTexts = [];
        foreach ($taskList as $task) {
            $name = preg_replace('/.*?\<input.+?\>(.*)/s', '$1', $task->getHtml());
            $trimmedText = $this->sanitizeText(preg_replace('/\<.+?\>/', '', $name));
            if ($trimmedText) {
                $taskTexts[] = $trimmedText;
            }
        }
        Assert::assertEquals(sizeof($taskNames), sizeof($taskTexts));
        foreach ($taskNames as $taskName) {
            Assert::assertNotFalse(array_search($taskName, $taskTexts));
        }
    }

    /**
     * @Then I see :type button next to task :task in :area
     *
     * @param string $type
     * @param string $task
     * @param string $area
     * @throws BehatException
     */
    public function testButton($type, $task, $area)
    {
        $typeIndex = self::TASK_BUTTONS[$type];
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        $extraList = $this->findAllCss('ul li div:first-child', $taskMenu);
        $button = null;
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                $extra = $extraList[$index];
                $button = $this->findCss("a:nth-child($typeIndex)", $extra);
                break;
            }
        }
        Assert::assertNotNull($button);
    }

    /**
     * @Then I see :bullet bullet in top menu
     *
     * @param string $bullet
     */
    public function testTopMenuBullet($bullet)
    {
        $this->wait(SHORT_WAIT_TIME);
        $header = $this->findCss('span#task_header');
        Assert::assertEquals($bullet, trim($header->getText()));
    }

    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        $this->cleanUpTasks();
    }
}
