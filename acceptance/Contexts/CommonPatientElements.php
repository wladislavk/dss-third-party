<?php

namespace Contexts;

use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

class CommonPatientElements extends BaseContext
{
    /**
     * @When I run mouse over patient task list
     */
    public function mouseOverTaskList()
    {
        $tasks = $this->findCss('span#pat_task_header');
        $tasks->mouseOver();
    }

    /**
     * @When I click :text button in patient header
     *
     * @param string $text
     * @throws BehatException
     */
    public function clickWarningsButton($text)
    {
        $warningButtons = $this->findAllCss('a.button');
        $theButton = null;
        foreach ($warningButtons as $warningButton) {
            if ($warningButton->getText() == $text) {
                $theButton = $warningButton;
                break;
            }
        }
        if (!$theButton) {
            throw new BehatException("Button with text $text not found");
        }
        $theButton->click();
    }

    /**
     * @Then I see the patient chart for :name
     *
     * @param string $name
     */
    public function testPatientChart($name)
    {
        $this->wait(SHORT_WAIT_TIME);
        $span = $this->findCss('div#patient_name_inner > span');
        Assert::assertNotNull($span);
        Assert::assertContains($name, $span->getText());
    }

    /**
     * @Then I see no patient chart
     */
    public function testNoPatientChart()
    {
        $this->wait(SHORT_WAIT_TIME);
        $span = $this->findCss('div#patient_name_inner > span');
        Assert::assertNull($span);
    }

    /**
     * @Then I see chart markings:
     *
     * @param TableNode $table
     */
    public function testChartMarkings(TableNode $table)
    {
        $span = $this->findCss('div#patient_name_inner > span');
        $links = $this->findAllCss('a', $span);
        $expected = $table->getHash();
        Assert::assertEquals(sizeof($expected), sizeof($links));
        foreach ($expected as $key => $element) {
            Assert::assertEquals($element['type'], $links[$key]->getText());
            Assert::assertEquals($element['title'], trim($links[$key]->getAttribute('title')));
        }
    }

    /**
     * @Then I see no chart markings
     */
    public function testNoChartMarkings()
    {
        $span = $this->findCss('div#patient_name_inner > span');
        $links = $this->findAllCss('a', $span);
        Assert::assertEquals(0, sizeof($links));
    }

    /**
     * @Then I see medicare icon
     */
    public function testMedicareIcon()
    {
        $this->wait(SHORT_WAIT_TIME);
        $icon = $this->findCss('div#patient_name_inner > img');
        Assert::assertNotNull($icon);
    }

    /**
     * @Then I see no medicare icon
     */
    public function testNoMedicareIcon()
    {
        $icon = $this->findCss('div#patient_name_inner > img');
        Assert::assertNull($icon);
    }

    /**
     * @Then I see patient warnings:
     *
     * @param TableNode $table
     */
    public function testPatientWarnings(TableNode $table)
    {
        $this->wait(SHORT_WAIT_TIME);
        $warnings = $this->findAllCss('div#patient_warnings span.warning');
        $expected = array_column($table->getHash(), 'text');
        Assert::assertEquals(sizeof($expected), sizeof($warnings));
        foreach ($expected as $key => $element) {
            Assert::assertTrue($warnings[$key]->isVisible());
            // getText() does not work for unknown reason
            $text = $this->sanitizeText(strip_tags($warnings[$key]->getHtml()));
            $warningText = str_replace("\n", ';', $text);
            Assert::assertEquals($element, $warningText);
        }
    }

    /**
     * @Then I see no patient warnings
     */
    public function testNoPatientWarnings()
    {
        $warnings = $this->findAllCss('div#patient_warnings > span.warning');
        $passed = true;
        foreach ($warnings as $warning) {
            if ($warning->isVisible()) {
                $passed = false;
            }
        }
        Assert::assertTrue($passed);
    }

    /**
     * @Then I see patient task list with :numberOfTasks tasks
     *
     * @param string $numberOfTasks
     */
    public function testTasks($numberOfTasks)
    {
        $tasks = $this->findCss('span#pat_task_header');
        Assert::assertNotNull($tasks);
        $text = "Tasks($numberOfTasks)";
        Assert::assertEquals($text, $tasks->getText());
    }

    /**
     * @Then I see no patient tasks
     */
    public function testNoTasks()
    {
        $tasks = $this->findCss('span#pat_task_header');
        $visible = false;
        if ($tasks && $tasks->isVisible()) {
            $visible = true;
        }
        Assert::assertFalse($visible);
    }

    /**
     * @Then I see :text button in patient header
     *
     * @param string $text
     */
    public function testWarningsButton($text)
    {
        $patientNameDiv = $this->findCss('div#patient_name_div');
        Assert::assertNotNull($patientNameDiv);
        $warningButtons = $this->findAllCss('a.button', $patientNameDiv->getParent());
        $theButton = null;
        foreach ($warningButtons as $warningButton) {
            if ($warningButton->getText() == $text) {
                $theButton = $warningButton;
                break;
            }
        }
        Assert::assertNotNull($theButton);
        Assert::assertTrue($theButton->isVisible());
    }
}
