<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use PHPUnit\Framework\Assert;
use Services\VueDateSelector;

class Tasks extends BaseContext
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

    private const COLUMN_NAME = 'name';
    private const COLUMN_DUE_DATE = 'due_date';
    private const COLUMN_ASSIGNED_TO = 'assigned_to';

    private const COLUMNS_NOT_COMPLETED = [
        self::COLUMN_NAME => 1,
        self::COLUMN_DUE_DATE => 2,
        self::COLUMN_ASSIGNED_TO => 3,
    ];

    private const COLUMNS_COMPLETED = [
        self::COLUMN_NAME => 0,
        self::COLUMN_DUE_DATE => 1,
        self::COLUMN_ASSIGNED_TO => 2,
    ];

    private const TASK_CREATED = 'Not existing test task';
    private const TASK_UPDATED = 'call for bar';
    private const TASK_DEACTIVATED = 'Set up webinar for Dr. X software training.';
    private const TASK_DELETED = 'asdasdasd';

    /** @var bool */
    private $taskCreatedOrUpdated = false;

    /** @var bool */
    private $taskDeactivated = false;

    /** @var bool */
    private $taskDeleted = false;

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
     * @When I fill task form with values:
     *
     * @param TableNode $table
     * @throws BehatException
     */
    public function fillTaskForm(TableNode $table)
    {
        $cells = $this->findAllCss('td.frmhead');
        foreach ($cells as $cellKey => $cell) {
            if (!$cell->isVisible()) {
                unset($cells[$cellKey]);
            }
        }
        $cells = array_values($cells);
        foreach ($table->getHash() as $key => $element) {
            switch ($element['type']) {
                case 'text':
                    $input = $this->findCss('input', $cells[$key]);
                    $input->setValue($element['value']);
                    break;
                case 'date':
                    $input = $this->findCss('input', $cells[$key]);
                    $input->click();
                    $this->wait(SHORT_WAIT_TIME);
                    $todayDiv = null;
                    if (SUT_HOST == 'vue') {
                        $vueDateSelector = new VueDateSelector();
                        $todayDiv = $vueDateSelector->getTodayElement($this);
                    } else {
                        $todayDiv = $this->findCss('div.DynarchCalendar-bottomBar-today');
                    }
                    $todayDiv->click();
                    $today = (new \DateTime())->format('m/d/Y');
                    $existingDate = $input->getValue();
                    if ($today != $existingDate) {
                        throw new BehatException("Today's date is $today, but $existingDate is used, check timezone settings");
                    }
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
            $this->taskCreatedOrUpdated = true;
        }
    }

    /**
     * @When I click delete task link for :task
     *
     * @param string $task
     * @throws BehatException|UnsupportedDriverActionException|DriverException
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
        $this->wait(SHORT_WAIT_TIME);
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
        $this->wait(SHORT_WAIT_TIME);
        $form = $this->findCss('form[name="notesfrm"]');
        $expectedRows = $table->getHash();
        $tableRows = $this->findAllCss('td.frmhead', $form);
        foreach ($tableRows as $key => $tableRow) {
            if (!$tableRow->isVisible()) {
                unset($tableRows[$key]);
            }
        }
        $tableRows = array_values($tableRows);
        array_pop($tableRows);
        Assert::assertEquals(sizeof($expectedRows), sizeof($tableRows));
        foreach ($expectedRows as $rowNumber => $row) {
            $column = $tableRows[$rowNumber];
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
     * @Then add task form is filled with values:
     *
     * @param TableNode $table
     */
    public function testPreFilledValues(TableNode $table)
    {
        $elements = $table->getHash();
        $cells = $this->findAllCss('td.frmhead');
        foreach ($cells as $cellKey => $cell) {
            $label = $this->findCss('label', $cell);
            if (!$cell->isVisible() || !$label) {
                unset($cells[$cellKey]);
            }
        }
        /** @var NodeElement[] $cells */
        $cells = array_values($cells);
        Assert::assertEquals(sizeof($elements), sizeof($cells));
        foreach ($elements as $key => $element) {
            $label = $this->findCss('label', $cells[$key]);
            Assert::assertNotNull($label);
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
     * @Then I see the list of tasks:
     * @param TableNode $expectedTasks
     */
    public function testSeeTheListOfTasks(TableNode $expectedTasks)
    {
        $this->checkTasks($expectedTasks->getHash(), '#not_completed_tasks', self::COLUMNS_NOT_COMPLETED);
    }

    /**
     * @Then I see the list of completed tasks:
     * @param TableNode $expectedTasks
     */
    public function testSeeTheListOfCompletedTasks(TableNode $expectedTasks)
    {
        $this->checkTasks($expectedTasks->getHash(), '#completed_tasks', self::COLUMNS_COMPLETED);
    }

    /**
     * @Then I see the list of tasks has :pagesCount pages
     * @param string $pagesCount
     */
    public function testSeeTheListOfTasksHasPages(string $pagesCount)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $pageLinks = $this->findAllCss('#non_cp_pages > *');
        $this->checkPages($pagesCount, $pageLinks);
    }

    /**
     * @Then I see the list of completed tasks has :pagesCount pages
     * @param string $pagesCount
     */
    public function testSeeTheListOfCompletedTasksHasPages(string $pagesCount)
    {
        $pageLinks = $this->findAllCss('#cp_pages > *');
        $this->checkPages($pagesCount, $pageLinks);
    }

    /**
     * @param string $pagesCount
     * @param array $pageLinks
     */
    private function checkPages(string $pagesCount, array $pageLinks)
    {
        Assert::assertEquals($pagesCount, count($pageLinks));
        for ($page = 1; $page <= $pagesCount; $page++) {
            $pageElement = $pageLinks[$page - 1];
            Assert::assertEquals($page, trim($pageElement->getText()));
        }
    }

    /**
     * @When I click :buttonName button in Tasks section
     * @param string $buttonName
     * @throws BehatException
     */
    public function clickButtonInTasksSection(string $buttonName)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $this->clickButton($buttonName);
    }

    /**
     * @When I click :buttonName button in the main section
     * @param string $buttonName
     * @throws BehatException
     */
    public function clickButtonInMainSection(string $buttonName)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        if ($this->clickElementWithText('#contentMain button.addButton', $buttonName)) {
            return;
        }

        throw new BehatException("Button with text '$buttonName' not found in main section.");
    }

    /**
     * @When I click add button in the modal with text :buttonName
     * @param string $buttonName
     * @throws BehatException
     */
    public function clickAddButtonInModal(string $buttonName)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        if ($this->clickElementWithText('form table button.addButton', $buttonName)) {
            return;
        }

        if ($this->clickElementWithValue('form table input[type="button"].addButton', $buttonName)) {
            return;
        }

        if ($this->clickElementWithValue('form table input[type="submit"].addButton', $buttonName)) {
            return;
        }

        throw new BehatException("Add button with text '$buttonName' not found in the modal.");
    }

    /**
     * @When I click :pageNumber pagination link above incomplete tasks table
     * @param string $pageNumber
     * @throws BehatException
     */
    public function clickPaginationLinkInIncompleteTasks(string $pageNumber)
    {
        $this->clickPagination('#non_cp_pages .fp', $pageNumber);
    }

    /**
     * @When I click :pageNumber pagination link above completed tasks table
     * @param string $pageNumber
     * @throws BehatException
     */
    public function clickPaginationLinkInCompletedTasks(string $pageNumber)
    {
        $this->clickPagination('#cp_pages .fp', $pageNumber);
    }

    /**
     * @When I click :columnText column in tasks table
     * @param string $columnText
     * @throws BehatException
     */
    public function clickColumnInTasksTable(string $columnText)
    {
        $this->clickHeaderLink('#not_completed_tasks .tr_bg_h a', $columnText);
    }

    /**
     * @When I click :columnText column in completed tasks table
     * @param string $columnText
     */
    public function clickColumnInCompletedTasksTable(string $columnText)
    {
        $this->clickHeaderLink('#completed_tasks .tr_bg_h a', $columnText);
    }

    /**
     * @param string $selector
     * @param string $columnText
     * @throws BehatException
     */
    private function clickHeaderLink(string $selector, string $columnText)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        if ($this->clickElementWithText($selector, $columnText)) {
            return;
        }

        throw new BehatException("Header link '$columnText' not found.");
    }

    /**
     * @When I fill task form on Manage Tasks page with values:
     * @param TableNode $table
     */
    public function fillTaskFormOnManageTasksPageWithValues(TableNode $table)
    {
        $this->fillTaskForm($table);
        $this->taskCreatedOrUpdated = true;
    }

    /**
     * @When I click delete task link for :task from Manage Tasks page
     * @param string $task
     */
    public function clickDeleteTaskLinkForFromManageTasksPage(string $task)
    {
        $this->clickDeleteButton($task);
        $this->taskDeleted = true;
    }

    /**
     * @When I click :buttonName button next to task :taskName on Manage Tasks page
     * @param string $buttonName
     * @param string $taskName
     * @throws BehatException
     */
    public function clickButtonNextToTaskOnManageTasksPage(string $buttonName, string $taskName)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $rows = $this->findAllCss('#not_completed_tasks tr');
        foreach ($rows as $row) {
            $taskRowText = trim($row->getText());
            if (strpos($taskRowText, $taskName) !== false) {
                $button = $row->find('css', '.editlink');
                $buttonText = trim($button->getText());
                if ($buttonName === $buttonText) {
                    $button->click();
                    return;
                }
            }
        }
        throw new BehatException("Button with text $buttonName not found for task $taskName");
    }

    /**
     * @When I click checkbox next to task :taskName on Manage Tasks page
     * @param string $taskName
     * @throws BehatException
     */
    public function clickCheckboxNextToTaskOnManageTasksPage(string $taskName)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $rows = $this->findAllCss('#not_completed_tasks tr');
        foreach ($rows as $row) {
            $taskRowText = trim($row->getText());
            if (strpos($taskRowText, $taskName) !== false) {
                $button = $row->find('css', 'input[type=checkbox]');
                if ($button) {
                    $button->click();
                    $this->taskDeactivated = true;
                    return;
                }
            }
        }
        throw new BehatException("Checkbox not found for task $taskName");
    }

    /**
     * @param array $expectedTasks
     * @param string $tableId
     * @param array $columnsNumbers
     * @throws BehatException
     */
    private function checkTasks(array $expectedTasks, string $tableId, array $columnsNumbers)
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $tableRows = $this->findAllCss(
            sprintf('%s tr:not(:first-child)', $tableId)
        );

        Assert::assertEquals(count($expectedTasks), count($tableRows));

        foreach ($expectedTasks as $index => $task) {
            if (isset($tableRows[$index])) {
                $cells = $tableRows[$index]->findAll('css', 'td');
                Assert::assertEquals($task[self::COLUMN_NAME], $this->sanitizeText($cells[$columnsNumbers[self::COLUMN_NAME]]->getText()));
                Assert::assertEquals($task[self::COLUMN_DUE_DATE], $this->sanitizeText($cells[$columnsNumbers[self::COLUMN_DUE_DATE]]->getText()));
                Assert::assertEquals($task[self::COLUMN_ASSIGNED_TO], $this->sanitizeText($cells[$columnsNumbers[self::COLUMN_ASSIGNED_TO]]->getText()));
            } else {
                throw new BehatException(sprintf("Task with text %s not found in table %s", $task['name'], $tableId));
            }
        }
    }

    /**
     * @param string $buttonName
     * @throws BehatException
     */
    private function clickButton(string $buttonName): void
    {
        if ($this->clickElementWithText('.index_task a.button', $buttonName)) {
            return;
        }

        throw new BehatException("Button with text '$buttonName' not found for tasks section.");
    }

    /**
     * Returns true if element has been clicked.
     *
     * @param $selector
     * @param string $buttonName
     * @return bool
     */
    private function clickElementWithText(string $selector, string $buttonName): bool
    {
        $elements = $this->findAllCss($selector);
        foreach ($elements as $element) {
            if ($buttonName === trim($element->getText())) {
                $element->click();
                return true;
            }
        }

        return false;
    }

    /**
     * Returns true if element has been clicked.
     *
     * @param $selector
     * @param string $buttonName
     * @return bool
     */
    private function clickElementWithValue(string $selector, string $buttonName): bool
    {
        $elements = $this->findAllCss($selector);
        foreach ($elements as $element) {
            if ($buttonName == trim($element->getAttribute('value'))) {
                $element->click();
                return true;
            }
        }

        return false;
    }

    /**
     * @param $selector
     * @param string $pageNumber
     * @throws BehatException
     */
    private function clickPagination(string $selector, string $pageNumber): void
    {
        $this->wait(MEDIUM_WAIT_TIME);

        if ($this->clickElementWithText($selector, $pageNumber)) {
            return;
        }

        throw new BehatException("Pagination link with value $pageNumber not found.");
    }


    /**
     * @AfterScenario
     */
    public function afterScenario()
    {
        if ($this->taskCreatedOrUpdated) {
            $this->executeQuery(sprintf("DELETE FROM dental_task WHERE task='%s';", self::TASK_CREATED));

            $this->executeQuery(
                sprintf(
                    "UPDATE dental_task SET task='call for fu', patientid=112, due_date='2014-03-06' WHERE task='%s';",
                    self::TASK_UPDATED
                )
            );
            $this->taskCreatedOrUpdated = false;
        }
        if ($this->taskDeactivated) {
            $this->executeQuery(sprintf("UPDATE dental_task SET status=0 WHERE task='%s';", self::TASK_DEACTIVATED));
            $this->taskDeactivated = false;
        }
        if ($this->taskDeleted) {
            $this->executeQuery(sprintf("UPDATE dental_task SET status=0 WHERE task='%s';", self::TASK_DELETED));
            $this->taskDeleted = false;
        }
    }
}
