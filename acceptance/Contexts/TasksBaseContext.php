<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Services\VueDateSelector;
use PHPUnit\Framework\Assert;
use Behat\Mink\Element\NodeElement;

abstract class TasksBaseContext extends BaseContext
{
    private const TASK_CREATED = 'Not existing test task';
    private const TASK_UPDATED = 'call for bar';
    private const TASK_DEACTIVATED = 'Set up webinar for Dr. X software training.';
    private const TASK_DELETED = 'asdasdasd';

    /** @var bool */
    protected $taskCreatedOrUpdated = false;

    /** @var bool */
    protected $taskDeactivated = false;

    /** @var bool */
    protected $taskDeleted = false;


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
     * @When I fill task form with values:
     *
     * @param TableNode $table
     * @return void
     *
     * @throws BehatException
     */
    public function fillTaskForm(TableNode $table): void
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
     * @Then I see add task form with header :header
     *
     * @param string $header
     * @return void
     */
    public function testAddTaskForm($header): void
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
     * @When I click delete task link for :task
     *
     * @param string $task
     * @return void
     *
     * @throws BehatException|UnsupportedDriverActionException|DriverException
     */
    public function clickDeleteButton($task): void
    {
        if (SUT_HOST == 'loader') {
            $this->getCommonClient()->switchToIFrame('aj_pop');
        }
        $link = $this->findElementWithText('a', 'Delete');
        $link->click();
        $this->taskDeleted = $task;
    }

    protected function cleanUpTasks()
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
