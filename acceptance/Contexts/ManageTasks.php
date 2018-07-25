<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class ManageTasks extends TasksBaseContext
{
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

    /**
     * @Then I see the list of tasks:
     * @param TableNode $expectedTasks
     * @return void
     */
    public function testSeeTheListOfTasks(TableNode $expectedTasks): void
    {
        $this->checkTasks($expectedTasks->getHash(), '#not_completed_tasks', self::COLUMNS_NOT_COMPLETED);
    }

    /**
     * @Then I see the list of completed tasks:
     * @param TableNode $expectedTasks
     */
    public function testSeeTheListOfCompletedTasks(TableNode $expectedTasks): void
    {
        $this->checkTasks($expectedTasks->getHash(), '#completed_tasks', self::COLUMNS_COMPLETED);
    }

    /**
     * @param array $expectedTasks
     * @param string $tableId
     * @param array $columnsNumbers
     * @return void
     *
     * @throws BehatException
     */
    private function checkTasks(array $expectedTasks, string $tableId, array $columnsNumbers): void
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
     * @Then I see the list of tasks has :pagesCount pages
     * @param string $pagesCount
     * @return void
     */
    public function testSeeTheListOfTasksHasPages(string $pagesCount): void
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $pageLinks = $this->findAllCss('#non_cp_pages > *');
        $this->checkPages($pagesCount, $pageLinks);
    }

    /**
     * @Then I see the list of completed tasks has :pagesCount pages
     * @param string $pagesCount
     * @return void
     */
    public function testSeeTheListOfCompletedTasksHasPages(string $pagesCount): void
    {
        $pageLinks = $this->findAllCss('#cp_pages > *');
        $this->checkPages($pagesCount, $pageLinks);
    }

    /**
     * @param string $pagesCount
     * @param array $pageLinks
     * @return void
     */
    private function checkPages(string $pagesCount, array $pageLinks): void
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
     * @return void
     *
     * @throws BehatException
     */
    public function clickButtonInTasksSection(string $buttonName): void
    {
        $this->wait(MEDIUM_WAIT_TIME);

        $this->clickButton($buttonName);
    }

    /**
     * @When I click :buttonName button in the main section
     * @param string $buttonName
     * @return void
     *
     * @throws BehatException
     */
    public function clickButtonInMainSection(string $buttonName): void
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
     * @return void
     *
     * @throws BehatException
     */
    public function clickAddButtonInModal(string $buttonName): void
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
     * @return void
     *
     * @throws BehatException
     */
    public function clickPaginationLinkInIncompleteTasks(string $pageNumber): void
    {
        $this->clickPagination('#non_cp_pages .fp', $pageNumber);
    }

    /**
     * @When I click :pageNumber pagination link above completed tasks table
     * @param string $pageNumber
     * @return void
     *
     * @throws BehatException
     */
    public function clickPaginationLinkInCompletedTasks(string $pageNumber): void
    {
        $this->clickPagination('#cp_pages .fp', $pageNumber);
    }

    /**
     * @When I click :columnText column in tasks table
     * @param string $columnText
     * @return void
     *
     * @throws BehatException
     */
    public function clickColumnInTasksTable(string $columnText): void
    {
        $this->clickHeaderLink('#not_completed_tasks .tr_bg_h a', $columnText);
    }

    /**
     * @When I click :columnText column in completed tasks table
     * @param string $columnText
     * @return void
     */
    public function clickColumnInCompletedTasksTable(string $columnText): void
    {
        $this->clickHeaderLink('#completed_tasks .tr_bg_h a', $columnText);
    }

    /**
     * @param string $selector
     * @param string $columnText
     * @return void
     *
     * @throws BehatException
     */
    private function clickHeaderLink(string $selector, string $columnText): void
    {
        $this->wait(MEDIUM_WAIT_TIME);

        if ($this->clickElementWithText($selector, $columnText)) {
            return;
        }

        throw new BehatException("Header link '$columnText' not found.");
    }


    /**
     * @When I click checkbox next to task :taskName on Manage Tasks page
     * @param string $taskName
     * @return void
     *
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
     * @When I click :buttonName button next to task :taskName on Manage Tasks page
     * @param string $buttonName
     * @param string $taskName
     * @return void
     *
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
     * @param string $buttonName
     * @return void
     *
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
     * @return void
     *
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
     * @return void
     */
    public function afterScenario(): void
    {
        $this->cleanUpTasks();
    }
}
