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
        $this->cleanUpTasks();
    }
}
