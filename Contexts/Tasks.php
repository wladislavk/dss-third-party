<?php

namespace Contexts;

use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use PHPUnit\Framework\Assert;

class Tasks extends BaseContext
{
    const TASK_MENUS = [
        'top menu' => 0,
        'dashboard' => -2,
    ];

    const TASK_BUTTONS = [
        'delete' => 1,
        'edit' => 2,
    ];

    /** @var string */
    private $taskDeactivated = '';

    /** @var string */
    private $taskDeleted = '';

    /** @var string */
    private $taskCreated = false;

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
     * @throws BehatException
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
                if ($type == 'delete') {
                    $this->prepareAlert();
                }
                $extra = $extraList[$index];
                $button = $this->findCss("a:nth-child($typeIndex)", $extra);
                if ($type == 'delete') {
                    $this->taskDeleted = $task;
                }
                $button->click();
                // there is a bug in legacy that prevents modal from opening for the first time
                if (SUT_HOST == 'loader' && $type == 'edit') {
                    $this->wait(self::SHORT_WAIT_TIME);
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
     * @When I fill task form with values:
     *
     * @param TableNode $table
     */
    public function fillTaskForm(TableNode $table)
    {
        $cells = $this->findAllCss('td.frmhead');
        foreach ($table->getHash() as $key => $element) {
            switch ($element['type']) {
                case 'text':
                    $input = $this->findCss('input', $cells[$key]);
                    $input->setValue($element['value']);
                    break;
                case 'date':
                    $value = $element['value'];
                    if ($element['value'] == 'today') {
                        $date = new \DateTime();
                        $value = $date->format('m/d/Y');
                    }
                    $input = $this->findCss('input', $cells[$key]);
                    $input->setValue($value);
                    break;
                case 'select':
                    $select = $this->findCss('select', $cells[$key]);
                    $option = $this->findElementWithText('option', $element['value'], $select);
                    $select->setValue($option->getAttribute('value'));
                    break;
                case 'checkbox':
                    $checkbox = $this->findCss('input', $cells[$key]);
                    if ($element['value'] == 'Yes') {
                        $checkbox->setValue(true);
                        break;
                    }
                    $checkbox->setValue(false);
                    break;
            }
            $this->taskCreated = true;
        }
    }

    /**
     * @When I click delete task link for :task
     *
     * @param string $task
     */
    public function clickDeleteButton($task)
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame('aj_pop');
        }
        $link = $this->findElementWithText('a', 'Delete');
        $link->click();
        $this->taskDeleted = $task;
    }

    /**
     * @Then I see add task form with header :header
     *
     * @param string $header
     */
    public function testAddTaskForm($header)
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame('aj_pop');
        }
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
        $this->wait(self::SHORT_WAIT_TIME);
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
     */
    public function testSubsections($area, TableNode $table)
    {
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
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
     * @param string $area
     * @param array $menus
     * @return NodeElement
     */
    private function getTaskMenu($area, array $menus)
    {
        $areaIndex = self::TASK_MENUS[$area];
        if ($areaIndex >= 0) {
            return $menus[$areaIndex];
        }
        return $menus[count($menus) + $areaIndex];
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
        $taskMenus = $this->findAllCss('div.task_menu');
        $taskMenu = $this->getTaskMenu($area, $taskMenus);
        $headers = $this->findAllCss('h4', $taskMenu);
        $lists = $this->findAllCss('ul', $taskMenu);
        $headerFound = false;
        $listKey = 0;
        foreach ($headers as $key => $header) {
            if ($header->getText() == $section) {
                $listKey = $key;
                $headerFound = true;
                break;
            }
        }
        Assert::assertTrue($headerFound);
        $taskList = $this->findAllCss('li div:last-child', $lists[$listKey - 1]);
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
        $this->wait(self::SHORT_WAIT_TIME);
        $header = $this->findCss('span#task_header');
        Assert::assertEquals($bullet, trim($header->getText()));
    }

    /**
     * @Then add task form is filled with values:
     *
     * @param TableNode $table
     */
    public function testPreFilledValues(TableNode $table)
    {
        $cells = $this->findAllCss('td.frmhead');
        foreach ($table->getHash() as $key => $element) {
            $label = $this->findCss('label', $cells[$key]);
            Assert::assertContains($element['field'], $label->getText());
            switch ($element['type']) {
                case 'text':
                    $input = $this->findCss('input', $cells[$key]);
                    Assert::assertEquals($element['value'], $input->getValue());
                    break;
                case 'select':
                    $select = $this->findCss('select', $cells[$key]);
                    $selectedOption = $this->findCss('option[value="' . $select->getValue() . '"]', $select);
                    Assert::assertEquals($element['value'], $selectedOption->getText());
                    break;
                case 'checkbox':
                    $checkbox = $this->findCss('input', $cells[$key]);
                    if ($element['value'] == 'Yes') {
                        Assert::assertTrue($checkbox->getValue());
                        break;
                    }
                    Assert::assertNull($checkbox->getValue());
                    break;
            }
        }
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
        if ($this->taskCreated) {
            $deleteQuery = <<<SQL
DELETE FROM dental_task
WHERE task='Test task';
SQL;
            $this->executeQuery($deleteQuery);
            $updateQuery = <<<SQL
UPDATE dental_task
SET task='call for fu'
WHERE task='call for bar';
SQL;
            $this->executeQuery($updateQuery);
        }
    }
}
