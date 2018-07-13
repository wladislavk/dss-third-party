<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\DriverException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Services\VueDateSelector;

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
