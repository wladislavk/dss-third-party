<?php

namespace Contexts;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class Tasks extends BaseContext
{
    const TASK_MENUS = [
        'top menu' => 0,
        'dashboard' => 1,
    ];

    const TASK_BUTTONS = [
        'delete' => 1,
        'edit' => 2,
    ];

    /** @var string */
    private $taskDeactivated = '';

    /** @var string */
    private $taskDeleted = '';

    /**
     * @When I click on task :task checkbox in :area
     *
     * @param string $task
     * @param string $area
     * @throws BehatException
     */
    public function clickOnTask($task, $area)
    {
        $areaIndex = self::TASK_MENUS[$area];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
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
     * @throws BehatException
     */
    public function clickOnButton($type, $task, $area)
    {
        $areaIndex = self::TASK_MENUS[$area];
        $typeIndex = self::TASK_BUTTONS[$type];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        $extraList = $this->findAllCss('ul li div:first-child', $taskMenu);
        $button = null;
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                if ($type == 'delete') {
                    $this->prepareAlert();
                }
                $extra = $extraList[$index];
                $button = $this->findCss("a:nth-child($typeIndex)", $extra);
                $button->click();
                if ($type == 'delete') {
                    $this->taskDeleted = $task;
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
        $areaIndex = self::TASK_MENUS[$area];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        foreach ($taskList as $index => $taskElement) {
            $taskText = trim($taskElement->getText());
            if ($taskText == $task) {
                $taskElement->mouseOver();
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
     * @Then I see add task form with header :header
     *
     * @param string $header
     */
    public function testAddTaskForm($header)
    {
        $this->getCommonClient()->switchToIFrame('aj_pop');

        $headerCell = $this->findCss('td.cat_head');
        Assert::assertNotNull($headerCell);
        Assert::assertEquals($header, $this->sanitizeText($headerCell->getText()));
    }

    /**
     * @Then add task form has following fields:
     *
     * @param TableNode $table
     */
    public function testAddTaskFormFields(TableNode $table)
    {
        $form = $this->findCss('form[name="notesfrm"]');
        $expectedRows = $table->getHash();
        $tableRows = $this->findAllCss('tbody > tr', $form);
        foreach ($expectedRows as $rowNumber => $row) {
            $childNumber = $rowNumber + 1;
            $column = $this->findCss('td', $tableRows[$childNumber]);
            $label = $this->findCss('label', $column);
            $labelText = str_replace(':', '', $label->getText());
            Assert::assertEquals($row['field'], $labelText);
            Assert::assertTrue($this->checkRequiredFormElement($column, $row['required']));
            Assert::assertTrue($this->checkFormElement($column, $row['type']));
        }
    }

    /**
     * @Then the :field form field is filled with value :value
     *
     * @param string $field
     * @param string $value
     */
    public function testAddTaskFormFieldData($field, $value)
    {
        // @todo: add method body
    }

    /**
     * @Then I see these task sub-sections in :area:
     *
     * @param string $area
     * @param TableNode $table
     */
    public function testSubsections($area, TableNode $table)
    {
        $areaIndex = self::TASK_MENUS[$area];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
        $subsectionHeaders = $this->findAllCss('h4', $taskMenu);
        if ($area == 'dashboard') {
            array_shift($subsectionHeaders);
        }
        $expected = array_column($table->getHash(), 'section');
        foreach ($expected as $index => $text) {
            Assert::assertEquals($text, $subsectionHeaders[$index]->getText());
        }
    }

    /**
     * @Then I see checkboxes with these tasks under :section section in :area:
     *
     * @param string $section
     * @param string $area
     * @param TableNode $table
     */
    public function testTasks($section, $area, TableNode $table)
    {
        $this->wait(self::MEDIUM_WAIT_TIME);
        $areaIndex = self::TASK_MENUS[$area];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
        Assert::assertNotNull($this->findElementWithText('h4', $section, $taskMenu));
        $taskList = $this->findAllCss('ul li div:last-child', $taskMenu);
        $taskNames = array_column($table->getHash(), 'task');
        $taskTexts = [];
        foreach ($taskList as $task) {
            $trimmedText = trim($task->getText());
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
     */
    public function testButton($type, $task, $area)
    {
        $areaIndex = self::TASK_MENUS[$area];
        $typeIndex = self::TASK_BUTTONS[$type];
        $taskMenu = $this->findAllCss('div.task_menu')[$areaIndex];
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
        $this->wait(self::SHORT_WAIT_TIME);
        $header = $this->findCss('span#task_header');
        Assert::assertEquals($bullet, trim($header->getText()));
    }

    /**
     * @AfterScenario
     *
     * @param AfterScenarioScope $scope
     */
    public function afterScenario(AfterScenarioScope $scope)
    {
        if ($this->taskDeactivated) {
            $query = <<<SQL
UPDATE dental_task
SET status=0
WHERE task='{$this->taskDeactivated}';
SQL;
            $this->executeQuery($query);
        }
        if ($this->taskDeleted) {
            $query = <<<SQL
UPDATE dental_task
SET status=0
WHERE task='{$this->taskDeleted}';
SQL;
            $this->executeQuery($query);
        }
    }
}
